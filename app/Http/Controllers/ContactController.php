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

        // Example: send email (you can also store in DB instead)
        Mail::raw($request->message, function ($mail) use ($request) {
            $mail->to('support@yourdomain.com') // change to your support email
                 ->subject($request->subject)
                 ->from($request->email, $request->name);
        });

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
