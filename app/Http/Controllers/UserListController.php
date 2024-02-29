<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    $viewUrl = route('admin.user.show', $user->id);
                    return '<td class="text-center d-flex justify-content-center align-items-center">
                            <a href="' . $viewUrl . '" class="btn btn-sm btn-dark mr-1"><i class="fa fa-eye"></i></a>
                        </td>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.user.index');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }
}
