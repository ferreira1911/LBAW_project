<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-form')->with([
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    
    public function reset(Request $request)
    {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed', 
        ]);

        
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Este link de recuperação é inválido ou expirou.']);
        }

        
        $user = User::where('email', $request->email)->first();
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        
        return redirect()->route('login')
            ->with('success', 'A sua password foi alterada com sucesso! Pode fazer login agora.');
    }
}