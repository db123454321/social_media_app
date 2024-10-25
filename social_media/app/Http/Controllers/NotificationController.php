<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return view('notifications.show', compact('notification'));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        
        return back()->with('success', 'Notification marked as read');
    }

    public function destroy(DatabaseNotification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return back()->with('success', 'All notifications cleared.');
    }
}
