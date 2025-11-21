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

		$notifications = Notification::where('user_id', $user->id)
			->orderBy('created_date', 'desc')
			->paginate(20);

		return view('pages.user.notifications', [
			'notifications' => $notifications,
		]);
	}


	/**
	 * Mark a notification as read.
	 */
	public function markAsRead(Notification $notification)
	{
		if (Auth::id() !== $notification->user_id) {
			abort(403);
		}

		try {
			$notification->is_read = true;
			$notification->save();
		} catch (\Exception $e) {
			Log::error('Failed marking notification as read', ['id' => $notification->id, 'error' => $e->getMessage()]);
			return back()->with('failure', 'Ocorreu um erro ao marcar a notificação como lida.');
		}

		return back()->with('success', 'Notificação marcada como lida.');
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
			return back()->with('failure', 'Ocorreu um erro ao marcar todas as notificações como lidas.');
		}

		return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
	}

	

}
