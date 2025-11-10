<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $cates = Category::all();
        $products = Product::orderByDesc('id')->paginate(10);
        return view('admin.product.index',compact('products','cates'),[
            'title' => 'Quản lý sản phẩm'
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'title' => 'required',
            'slug' => 'required|unique:products',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề !',
            'slug.required' => 'Vui lòng nhập slug',
            'slug.unique' => 'Slug này đã tồn tại',
        ]);
        // Kiểm tra xem product_id có tồn tại trong bảng Product hay không
        $product = new Product;
        $title = $request->title;
        $product->Title = $title ;
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/temp/images/product/'), $fileName);
                    $imagePaths[] =  $fileName;
                }
            }
        }

        $product->images = !empty($imagePaths) ? json_encode($imagePaths) : null;
        $product->thumb = !empty($imagePaths) ? $imagePaths[0] : null;
        $product->description = $request->desc;
        $product->slug = $request->slug;
        $product->cate_id = $request->cate_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->active = 1;
        $product->ishot = $request->ishot ? 1 : 0;
        $product->isnewfeed = 1;
        $product->thongsokythuat = $request->thongsokythuat;
        $product->Amounts = $request->amount;
        $product->content = $request->content;
        $product->types = $request->types;

        $product->save();
        // Chuyển hướng về trang hiển thị danh sách product hoặc trang khác tùy theo yêu cầu của bạn
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,[
            'title' => 'required',
            'slug' => 'required',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề !',
            'slug.required' => 'Vui lòng nhập slug',
        ]);
        // Kiểm tra xem product_id có tồn tại trong bảng Product hay không
        $title = $request->title;
        $product->Title = $title ;
          $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/temp/images/product/'), $fileName);
                    $imagePaths[] = $fileName;
                }
            }
        }

        if (!empty($imagePaths)) {
            $product->images = json_encode($imagePaths);
            $product->thumb = $imagePaths[0];
        }
        $product->description = $request->desc;
        $product->slug = $request->slug;
        $product->cate_id = $request->cate_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->active = $request->active ? 1 : 0;
        $product->ishot = $request->ishot ? 1 : 0;
        $product->isnewfeed = $request->isnewfeed ? 1 : 0;
        $product->thongsokythuat = $request->thongsokythuat;
        $product->Amounts = $request->amount;
        $product->content = $request->content;
        $product->types = $request->types;

        $product->save();
        // Chuyển hướng về trang hiển thị danh sách product hoặc trang khác tùy theo yêu cầu của bạn
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        // Chuyển hướng về trang danh sách product hoặc trang khác (tuỳ ý)
        return response()->json(['message' => 'Sản phẩm đã được xóa thành công']);
    }

    public function deleteAllProducts() {
        Product::truncate(); // Xóa tất cả bản ghi
        return redirect()->back();
    }
}
