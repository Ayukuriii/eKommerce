<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(15);

        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $items = $order->items;

        return view('admin.order.show', compact('items'));
    }
}
