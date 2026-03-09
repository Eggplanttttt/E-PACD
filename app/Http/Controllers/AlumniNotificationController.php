<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class AlumniNotificationController extends Controller
{
    public function index()
    {
        $user = auth('alumni')->user();
        abort_if(!$user, 403);

        $notifications = Notification::where('client_id', $user->id)
            ->where('user_type', 'Alumni')   
            ->latest()
            ->take(20)
            ->get(['id','title','message','is_read','created_at']);

        $unread = Notification::where('client_id', $user->id)
            ->where('user_type', 'Alumni')
            ->where('is_read', 0)
            ->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unread,
        ]);
    }

    public function markRead()
    {
        $user = auth('alumni')->user();
        abort_if(!$user, 403);

        Notification::where('client_id', $user->id)
            ->where('user_type', 'Alumni')
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function deleteRead()
    {
        $user = auth('alumni')->user();
        abort_if(!$user, 403);

        Notification::where('client_id', $user->id)
            ->where('user_type', 'Alumni')
            ->where('is_read', 1)
            ->delete();

        return response()->json(['success' => true]);
    }
}