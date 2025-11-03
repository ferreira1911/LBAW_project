<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // **NEW**: Import the User model
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
            return redirect()->route('/'); 
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
 
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->is_deleted) {
            return back()->withErrors([
                'email' => 'This account has been deleted.',
            ])->onlyInput('email');
        }

        // 2. Attempt to authenticate and log in the user.
        if (Auth::attempt($credentials, $request->filled('remember'))) {
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
 
        return redirect('auctions.index');
    }
}