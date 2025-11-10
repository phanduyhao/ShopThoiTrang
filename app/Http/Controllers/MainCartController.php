<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainCartController extends Controller
{
    public function cart(){
        $carts = Cart::where('user_id',Auth::id())->paginate(10);
        return view('cart.index',compact('carts'),[
            'title' => 'Giỏ hàng'
        ]);
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        // Chuyển hướng về trang danh sách post hoặc trang khác (tuỳ ý)
        return redirect()->back();
    }

    public function updateQuantities(Request $request)
    {
        $cartUpdates = $request->input('cart_updates');
        $errors = [];

        foreach ($cartUpdates as $cartUpdate) {
            $cart = Cart::findOrFail($cartUpdate['id']);
            $newQuantity = $cartUpdate['quantity'];

            $product = Product::find($cart->product_id);

            if ($product) {
                if ($newQuantity > $product->Amounts) {
                    $errors[] = "Sản phẩm {$product->Title} vượt quá số lượng tồn kho.";
                } else {
                    $cart->quanity = $newQuantity;
                    $cart->subtotal = $cart->quanity * $cart->price;
                    $cart->save();
                }
            }
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 400);
        }

        // Trả về dữ liệu mới cho cập nhật trên trang
        return response()->json(['success' => true]);
    }

    public function checkStock(Request $request)
{
    $cartUpdates = $request->input('cart_updates');
    $errors = [];

    foreach ($cartUpdates as $update) {
        $cart = Cart::find($update['id']);

        if (!$cart || $cart->user_id !== Auth::id()) {
            $errors[] = "Giỏ hàng không tồn tại hoặc không thuộc quyền.";
            continue;
        }

        $product = Product::find($cart->product_id);
        if (!$product) {
            $errors[] = "Sản phẩm không tồn tại.";
            continue;
        }

        $newQty = $update['quantity'];
        if ($newQty > $product->Amounts) {
            $errors[] = "Sản phẩm '{$product->Title}' chỉ còn {$product->Amounts} trong kho.";
        }
    }

    if (!empty($errors)) {
        return response()->json(['success' => false, 'errors' => $errors], 400);
    }

    return response()->json(['success' => true]);
}


}
