<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('id','desc')->paginate(10);

        return view('admin.feedback.index', compact('feedbacks'), [
            'title' => 'Quản lý phản hồi'
        ]);
    }
}
