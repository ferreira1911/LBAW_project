<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent; // We will create this next
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display the list of conversations (Inbox).
     * Groups messages by the "other" user to show a list of chats.
     */
    public function index()
    {
        $userId = Auth::id();

        // Complex query to get the latest message for every conversation
        // This effectively creates a list of "recent chats"
        $conversations = Message::select('message.*')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('message')
                    ->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId)
                    ->groupBy(DB::raw('LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)'));
            })
            ->with(['sender', 'receiver'])
            ->orderBy('sent_date', 'desc')
            ->get();

        return view('pages.messages.index', [
            'conversations' => $conversations
        ]);
    }

    /**
     * Display the conversation with a specific user.
     */
    public function show(User $user)
    {
        $myId = Auth::id();

        // Fetch messages between Me and User
        $messages = Message::where(function ($q) use ($myId, $user) {
            $q->where('sender_id', $myId)
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($myId, $user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $myId);
        })
        ->orderBy('sent_date', 'asc') // Oldest first (chat style)
        ->get();

        // Mark messages from them as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('pages.messages.show', [
            'receiver' => $user,
            'messages' => $messages,
        ]);
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string|max:1000',
            'auction_id'  => 'nullable|exists:auction,id',
        ]);

        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');

        if ($senderId == $receiverId) {
            return response()->json(['error' => 'You cannot talk to yourself.'], 422);
        }

        $message = Message::create([
            'sender_id'   => $senderId,
            'receiver_id' => $receiverId,
            'content'     => $validated['content'],
            'auction_id'  => $request->input('auction_id'),
            'is_read'     => false,
            'sent_date'   => now(),
        ]);

        // Load sender relationship so JS can display the name/avatar immediately
        $message->load('sender');

        event(new NewMessage($message->receiver,$message['content']));


        // Always return JSON for CSR
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy(Message $message)
    {
        // Only the sender can delete their message
        if ($message->sender_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        return back()->with('success', 'Message deleted.');
    }
}