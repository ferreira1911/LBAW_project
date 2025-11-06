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
use App\Http\Controllers\FileController;


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
        return view('pages.user.edit',[
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'description' => ['nullable', 'string', 'max:1000'],
            'url' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // The form input
            'password' => ['nullable', 'confirmed'],
        ]);

        if ($request->hasFile('url')) {
            // A. Delete the old file
            FileController::delete('profile', $user->id);

            // B. Store the new file
            $file = $request->file('url');
            $fileName = $file->hashName();
            $folderPath = 'images/profile'; // Path from FileController
            $file->storeAs($folderPath, $fileName, FileController::$diskName); // Disk from FileController

            
            $validated['url'] = $fileName;
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.show', $user)->with('success', 'User profile updated successfully.');
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