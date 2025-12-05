<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('auctions.index'); 
        } else {
            return view('auth.login');
        }
    }

    /**
     * Process an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validate the request data.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
        
            $user = Auth::user();

            // Check if User is Blocked (US504)
            if ($user->isBlocked()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your Account has been Blocked. Please contact Support.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('auctions.index'));
        }
 
        // 3. Authentication failed.
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect()->route('auctions.index');
    }
}