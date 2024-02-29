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
        if (request()->ajax()) {
            $notifications = auth()->user()->notifications;

            return DataTables::of($notifications)
                ->addColumn('#', function ($notification) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('title', function ($notification) {
                    $title = $notification->data['title'];
                    return $title;
                })
                ->addColumn('category', function ($notification) {
                    $category = $notification->data['category'];
                    return $category;
                })
                ->addColumn('body', function ($notification) {
                    $body = $notification->data['body'];
                    return $body;
                })
                ->addColumn('status', function ($notification) {
                    if ($notification->read_at) {
                        return '<td>
                                    <i class="fa fa-check" style="color: green"></i>
                                    Read
                                </td>';
                    } else {
                        return '<td>' . $notification->created_at->diffForHumans() . '</td>';
                    }
                })
                ->addColumn('action', function ($notification) {
                    $link = route('notifications.readNotification', $notification->id);
                    if (isset($notification->data['link'])) {
                        return '<td class="text-center">
                        <a href="' . $link . '"
                            class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                    </td>';
                    } else {
                        return '<td></td>';
                    }
                })
                ->rawColumns(['#', 'title', 'category', 'body', 'status', 'action'])
                ->make(true);
        }

        return view('admin.notification.index');
    }

    public function readNotification(string $id)
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->first();
        $jsonDecode = json_decode($notification->data);
        DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);
        return redirect($jsonDecode->link);
    }

    public function getNotification()
    {
        return [
            'label'       => count(auth()->user()->unreadNotifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
        ];
    }
}
