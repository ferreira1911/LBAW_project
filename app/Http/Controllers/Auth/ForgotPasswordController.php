<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Mail\ResetPasswordMail; 

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the form submission and send the email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        
        $token = Str::random(64);

        
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        
        $user = User::where('email', $request->email)->first();

        
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        
        $mailData = [
            'name' => $user->name,
            'url' => $resetUrl,
        ];

        
        Mail::to($request->email)->send(new ResetPasswordMail($mailData));

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

}