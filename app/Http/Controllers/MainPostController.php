<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class MainPostController extends Controller
{
    public function index(){

        $posts = Post::where('active',1)->paginate(6);
        $post_news = Post::where('active',1)->where('isnewfeed',1)->take(3)->get();
        $post_hots = Post::where('active',1)->where('ishot',1)->take(3)->get();
        return view('post.index',compact('posts','post_news','post_hots'),[
            'title' => 'Tin tức'
        ]);
    }

   public function details($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Lấy 6 bài viết mới nhất (không tính bài hiện tại)
        $latest_posts = Post::where('active', 1)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(6)
            ->get();

        return view('post.details', [
            'post' => $post,
            'latest_posts' => $latest_posts,
            'title' => $post->Title
        ]);
    }

}
