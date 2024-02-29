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
        $data = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'data' => $notification->data,
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $user = $request->user();
        $notifications = $user->notifications()->findOrFail($id);
        $read = $notifications->markAsRead();

        return response()->json($notifications);
    }
}
