<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders;

        return response()->json(['orders' => $orders]);
    }

    public function getOrderItems(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders->first();
        $items = $orders->items;

        return response()->json(['items' => $items]);
    }
}
