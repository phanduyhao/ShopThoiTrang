<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainProductController extends Controller
{
    public function shop(Request $request)
    {
        // Lấy danh sách sản phẩm theo cate_id của danh mục
        $query = Product::where('active', 1);
        $nameProduct = $request->nameProduct;

            // Kiểm tra xem có yêu cầu tìm kiếm không
        if ($request->has('nameProduct') && $nameProduct != '') {
            $query->where('Title', 'LIKE', '%' . $nameProduct . '%'); // Tìm kiếm theo tên sản phẩm
        }
        // Kiểm tra xem có yêu cầu sắp xếp theo giá không
        if ($request->has('sort')) {
            if ($request->sort == 1) {
                $query->orderBy('id', 'asc'); // Thấp đến cao
            } elseif ($request->sort == 2) {
                $query->orderBy('id', 'desc'); // Cao đến thấp
            }
        }
        $pages = 6;
        // Phân trang sản phẩm
        $products = $query->paginate($pages);
        $category_all = Category::all();
        
        // Lấy danh sách các danh mục con không có cha
        $category_no_parent_ids = Category::where('parent_id', '!=', null)->get();
        return view('product.shop', compact( 'products', 'category_no_parent_ids','pages','nameProduct','category_all'),[
            'title'=>'Cửa hàng'
        ]);
    }


    // public function ShowProduct($categorySlug)
    // {
    //     $category = Category::where('slug', $categorySlug)->firstOrFail();
    //     $products = Product::where('cate_id', $category->id)->paginate(6);
    //     $category_no_parent_ids = Category::where('parent_id','!=',null)->get();
    //     return view('product.list_product', compact('category', 'products','category_no_parent_ids'),[
    //         'title'=>'Sản phẩm '. $category->title
    //     ]);
    // }

    public function ShowProduct(Request $request, $categorySlug)
    {
        // Lấy danh mục dựa trên slug
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        // Lấy danh sách sản phẩm theo cate_id của danh mục
        $query = Product::where('cate_id', $category->id);
        $nameProduct = $request->nameProduct;

            // Kiểm tra xem có yêu cầu tìm kiếm không
        if ($request->has('nameProduct') && $nameProduct != '') {
            $query->where('Title', 'LIKE', '%' . $nameProduct . '%'); // Tìm kiếm theo tên sản phẩm
        }
        // Kiểm tra xem có yêu cầu sắp xếp theo giá không
        if ($request->has('sort')) {
            if ($request->sort == 1) {
                $query->orderBy('id', 'asc'); // Thấp đến cao
            } elseif ($request->sort == 2) {
                $query->orderBy('id', 'desc'); // Cao đến thấp
            }
        }
        $pages = 6;
        // Phân trang sản phẩm
        $products = $query->paginate($pages);
        
        // Lấy danh sách các danh mục con không có cha
        $category_all = Category::all();
        
        // Trả về view với các biến đã chuẩn bị
        return view('product.list_product', compact('category', 'products', 'category_all','pages','categorySlug','nameProduct'), [
            'title' => 'Sản phẩm ' . $category->title
        ]);
    }

    public function ProductDetail($slug){
        $product = Product::where('slug', $slug)->first();
        $new_products = Product::where('active', true)->orderByDesc('id')->take(4)->get();
        $title = $product->Title;
        $initialCommentsCount = 2; // Số lượng ban đầu hiển thị
        $loadMoreCommentsCount = 5;
        $comments = Comment::where('product_id', $product->id)->take($initialCommentsCount)->get();
        $types = array_filter(array_map('trim', explode(',', $product->types ?? '')));

        return view('product.details',compact('product','new_products','comments','initialCommentsCount','loadMoreCommentsCount','types'),[
            'title' => $title
        ]);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = $request->input('user_id');
        $thumb = $request->input('thumb');
        $name = $request->input('name');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $subtotal = $request->input('subtotal');
        $types = $request->input('types');
        // Kiểm tra xem đã có bản ghi có user_id và product_id tương ứng chưa
        $existingRecord = Cart::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();
        if (!$existingRecord) {
            $cart = new Cart;
            $cart->product_id = $productId;
            $cart->thumb = $thumb;
            $cart->user_id = $userId;
            $cart->price = $price;
            $cart->nameProduct = $name;
            $cart->quanity = $quantity;
            $cart->subtotal =$subtotal;
            $cart->types =$types;
            $cart->save();
        }else{
            $existingRecord->quanity =  $existingRecord->quanity + $quantity;
            $existingRecord->subtotal =  $existingRecord->subtotal * $existingRecord->quanity;
            $existingRecord->save();
        }
        return response()->json(['success' => true, 'message' => 'Thêm giỏ hàng thành công!']);
    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->comment = $request->input('comment');
        $comment->parent_comment_id = $request->input('parent_comment_id');
        $comment->product_id = $request->input('product');
        $user_name = $comment->user->name;
        $comment->save();
        return response()->json(['comment' => $comment->comment, 'user_name' => $user_name]); // Return the new comment and user_name as JSON
    }
    

    //    hiển thị thêm bình luận
    public function loadComments(Request $request)
    {
        $product_id = $request->input('product_id');
        $offset = $request->input('offset'); // Số lượng bình luận hiện tại
        $loadMoreCommentsCount = $request->input('loadMoreCommentsCount'); // Số lượng bình luận muốn load thêm

        // Lấy thêm bình luận bằng cách sử dụng offset và số lượng muốn load
        $comments = Comment::where('product_id', $product_id)
            ->skip($offset)
            ->take($loadMoreCommentsCount)
            ->orderByDesc('id')
            ->get();
        foreach ($comments as $comment) {
            $comment->load('user'); // Load dữ liệu người bình luận
            $comment->avatar = $comment->user->avatar; // Lưu avatar vào thuộc tính mới
            $comment->name = $comment->user->name;
        }

        return response()->json(['comments' => $comments]);
    }
    
}
