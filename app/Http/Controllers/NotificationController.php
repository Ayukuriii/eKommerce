<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->notifications);

        // if (request()->ajax()) {
        //     $notifications = auth()->user()->notifications;

        //     return DataTables::of($notifications)->make(true);
        // }
        $notifications = auth()->user()->notifications;
        return view('admin.notification.index', compact('notifications'));
    }

    public function show()
    {
        // 
    }

    public function getNotification()
    {
        return [
            'label'       => count(auth()->user()->notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
        ];
    }
}
