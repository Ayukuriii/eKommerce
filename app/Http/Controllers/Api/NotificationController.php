<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getAll(Request $request)
    {
        $user = $request->user();
        $notifications = $user->unreadNotifications;
        return response()->json(['data' => $notifications]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $user = $request->user();
        $notifications = $user->notifications()->findOrFail($id);
        $read = $notifications->markAsRead();

        return response()->json($notifications);
    }
}
