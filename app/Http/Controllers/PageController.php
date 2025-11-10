<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackReceived;

class PageController extends Controller
{
    public function about(){
        return view('page.about',[
            'title' => 'Giới thiệu'
        ]);
    }
    public function contact(){
        return view('page.contact',[
            'title' => 'Liên hệ'
        ]);
    }

    public function sendFeedback(Request $request)
    {
        $feedback = new Feedback;
        $feedback->name = $request->name;
        $feedback->email = $request->email;
        $feedback->contents = $request->contents;
        $feedback->save();
        $emailData = [
            'name' => $request->name,
            'email' => $request->email,
            'contents' => $request->contents,
        ];

        Mail::to(config('mail.from.address'))->send(new FeedbackReceived($emailData));

        return redirect()->back();
    }
}
