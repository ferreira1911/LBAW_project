<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NotificationController extends Controller
{
	/**
	 * Display a listing of the notifications for the authenticated user.
	 */
	public function index()
	{
		$user = Auth::user();

		$unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

		$notifications = Notification::where('user_id', $user->id)
			->orderBy('created_date', 'desc')
			->paginate(20);

		return view('pages.user.notifications', [
			'notifications' => $notifications,
			'unreadCount' => $unreadCount,
		]);
	}


	/**
	 * Mark a notification as read.
	 */
	public function markAsRead(Notification $notification)
	{
		$notification->update(['is_read' => true]);

    	return response()->json(['success' => true]);
	}

	/**
	 * Mark all notifications as read for the authenticated user.
	 */
	public function markAllRead(Request $request)
	{
		$user = Auth::user();

		try {
			Notification::where('user_id', $user->id)->where('is_read', false)->update(['is_read' => true]);
		} catch (\Exception $e) {
			Log::error('Failed marking all notifications as read', ['user' => $user->id, 'error' => $e->getMessage()]);
			
			if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating notifications'], 500);
            }
            return back()->with('failure', 'An error occurred while marking notifications as read.');
		}

		if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'All marked as read']);
        }

        return back()->with('success', 'All notifications marked as read.');
	}

	

}
