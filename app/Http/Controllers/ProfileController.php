<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function infoProfile()
    {
        return view('profile.info',[
            'title' => 'Thông tin cá nhân'
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id); // Lấy người dùng theo ID
        
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'sex' => 'required|string',
            'avatar' => 'nullable|image|max:2048', // Kiểm tra định dạng ảnh
        ]);

        // Cập nhật thông tin cơ bản
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->sex = $request->input('sex');

        // Cập nhật ảnh đại diện nếu có
        $avatar = $request->file('avatar');
        if ($avatar) {
            $fileName = Str::slug($user->name) . '.jpg'; // Tạo tên file dựa theo Slug Name
            $avatar->move(public_path('/temp/images/avatar/'), $fileName); // Lưu vào thư mục tạm
    
            $user->avatar = '/temp/images/avatar/' . $fileName; // Lưu đường dẫn vào database
        }

        // Lưu thay đổi vào database
        $user->save();

        // Quay lại trang thông tin cá nhân và thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function showChangePass(){
        return view('profile.changePass', [
            'title' => 'Thay đổi mật khẩu'
        ]);
    }

    public function changePass(Request $request)
    {
        $user = Auth::user(); // ✅ Lấy user đang đăng nhập
    
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ!',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới!',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự!',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp!',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['old_password' => ['Mật khẩu cũ không đúng!']],
            ], 422);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công!',
        ]);
    }

    public function myOrder(Request $request)
    {
        // Lấy status từ request, nếu không có thì mặc định là tất cả trạng thái
        $status = $request->status;
    
        // Nếu có status, lọc theo status
        if ($status) {
            // Kiểm tra nếu status là một giá trị hợp lệ, ví dụ: 1, 2, 3, 4
            $orders = Order::where('user_id', Auth::user()->id)
                           ->where('status', $status)
                           ->get();
        } else {
            // Nếu không có status, lấy tất cả đơn hàng của người dùng
            $orders = Order::where('user_id', Auth::user()->id)->get();
        }
    
        // Trả về kết quả dưới dạng JSON hoặc view tùy theo nhu cầu
        return view('profile.myOrder', compact('orders'),[
            'title' => 'Đơn hàng của bạn'
        ]);
    }


public function cancel($id)
{
    $order = Order::findOrFail($id);

    if ($order->status != 4) {
        // Bắt đầu transaction để đảm bảo toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // Giải mã chuỗi JSON sản phẩm
            $products = json_decode($order->products, true);

            foreach ($products as $productData) {
                $slug = $productData['slug'] ?? null;
                $quantity = $productData['quantity'] ?? 0;

                if ($slug && $quantity > 0) {
                    // Tìm sản phẩm theo slug
                    $product = Product::where('slug', $slug)->first();

                    if ($product) {
                        // Cập nhật số lượng
                        $currentAmount = (int) $product->Amounts; // đảm bảo kiểu số
                        $product->Amounts = $currentAmount + $quantity;
                        $product->save();
                    }
                }
            }

            // Cập nhật trạng thái đơn hàng
            $order->status = 4;
            $order->save();

            DB::commit();

            return redirect()->route('myOrder')->with('success', 'Đơn hàng đã bị hủy và sản phẩm đã được hoàn lại kho!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('myOrder')->with('error', 'Lỗi khi hủy đơn hàng: ' . $e->getMessage());
        }
    }

    return redirect()->route('myOrder')->with('error', 'Không thể hủy đơn hàng này!');
}


    
}
