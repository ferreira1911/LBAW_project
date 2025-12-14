<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Models\Auction;
use App\Models\Message;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Auth::user());
        return view('pages.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $canViewBalance = false;
        if (Auth::check() && (Auth::id() === $user->id || Auth::user()->is_admin)) {
            $canViewBalance = true;
        }

        if (!$user->is_deleted) {
            $auctions = $user->auctions()->orderBy('end_date', 'DESC')->get();

            return view('pages.user.profile', [
                'user' => $user,
                'canViewBalance' => $canViewBalance,
                'auctions' => $auctions,
            ]);
        }

        return redirect()->route('auctions.index')->with('failure', 'This account has been deleted');
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

        return redirect()->route('users.show', $user)->with('success', 'User profile updated successfully.');
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

        return back()->with('success', 'User profile deleted successfully.');
    }

    public function getUsers(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('is_deleted', false); 

        if ($search) {
            
            $query->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$search])
                  ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$search]);
        } else {
            $query->orderBy('id', 'desc');
        }

        $users = $query->paginate(20);

        return response()->json($users);
    }

    public function create(){
        $this->authorize('create',Auth::user());
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        
        $this->authorize('create', User::class);

        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'is_admin' => ['nullable', 'boolean'], 
        ]);

        try {
            
            $dataToCreate = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => $request->has('is_admin') 
            ];

            
            User::create($dataToCreate);

        } catch (\Exception $e) {
            Log::error('Falha ao criar utilizador (Admin): ' . $e->getMessage());
            return redirect()->back()
                             ->with('failure', 'Ocorreu um erro ao criar o utilizador.')
                             ->withInput(); // Mantém os dados no formulário
        }

        return redirect()->route('users.index')
                         ->with('success', 'Utilizador criado com sucesso!');
    }

    public function block(User $user)
    {
        $this->authorize('block', $user);

        $user->update(['is_blocked' => true]);

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblock(User $user)
    {
        $this->authorize('unblock', $user);

        $user->update(['is_blocked' => false]);

        return back()->with('success', 'User unblocked successfully.');
    }

    public function loadAuctions(User $user)
    {
        $auctions = $user->auctions()->orderBy('end_date','DESC')->paginate(12);
        return view('partials.user-auctions', compact('auctions', 'user')); 
    }

    public function loadWatchlist(User $user)
    {
        $auctions = $user->followedAuctions()->paginate(12);
        return view('partials.watchlist', compact('auctions'));
    }

    public function loadWon(User $user)
    {
        $auctions = $user->wonAuctions()->paginate(12);
        return view('partials.won-auctions', compact('auctions'));
    }


   public function loadMessages(User $user)
{
    $conversations = Message::where('sender_id', $user->id)
                            ->orWhere('receiver_id', $user->id)
                            ->orderBy('sent_date', 'desc')
                            ->get();

    return view('partials.messages', compact('conversations'));
}
}