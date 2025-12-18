<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\FileController;


class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle() {
        try {
            $google_user = Socialite::driver('google')->stateless()->user();
            
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {

                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password' => null,
                ]);

                FileController::saveProfileImageFromUrl($user->id, $google_user->getAvatar());
            }

            if ($user->isBlocked()) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Your Account has been Blocked. Please contact Support.',
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');
            
        } catch (\Exception $e) {
            
            return redirect('login')->with('error', 'Something went wrong with Google Login: ' . $e->getMessage());
        }
    }
}
