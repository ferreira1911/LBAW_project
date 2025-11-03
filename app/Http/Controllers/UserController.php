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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

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

        // Delete the user's profile
        $user->deleteUser();

        if (auth()->user()->id === $user->id) {
            // Log out the user if they are deleting their own profile
            auth()->logout();
        }

        return redirect('/auction')->with('success', 'User profile deleted successfully.');
    }

    public function create() {
        
    }

    public function storeUser(Request $request)
    {

        
    }




}