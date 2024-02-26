<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate1 = Carbon::now()->subDays(2)->startOfDay();
        $endDate1 = Carbon::now()->endOfDay();
        $orderCount = DB::table('orders')
            ->whereBetween('created_at', [$startDate1, $endDate1])
            ->count();

        $productCount = DB::table('products')->count();

        $startDate2 = Carbon::now()->subWeek()->startOfDay();
        $endDate2 = Carbon::now()->endOfDay();
        $userCount = DB::table('users')
            ->whereBetween('created_at', [$startDate2, $endDate2])
            ->count();
        return view('admin.dashboard', compact('orderCount', 'productCount', 'userCount'));
    }
}
