<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Show the contact form
    public function index()
    {
        return view('pages.contact');
    }

    // Handle form submission
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::raw($request->message, function ($mail) use ($request) {
            $mail->to('hello@auctionease.com')
                 ->subject($request->subject)
                 ->from($request->email, $request->name);
        });

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
