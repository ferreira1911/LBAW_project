<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $canViewBalance = false;
        if (Auth::check()) { // Check if a user is even logged in
            if (Auth::id() === $user->id || Auth::user()->is_admin) {
                $canViewBalance = true;
            }
        }
       if(!$user->is_deleted){
            return view('pages.user.profile',[
            'user' => $user,
            'canViewBalance' => $canViewBalance,
        ]);
       }
       return redirect('/auction')->with('failure', 'This account has been deleted');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        // Validate the request data, restricting to only username, profile_picture, and address
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id, // Exclude current user's username from uniqueness check
            'url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image upload validation
        ]);

        return redirect('/auction')->with('success', 'User profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        $user->deleteUser();

        if (auth()->user()->id === $user->id) {
            // Log out the user if they are deleting their own profile
            auth()->logout();
        }

        return redirect('/auction')->with('success', 'User profile deleted successfully.');
    }


}