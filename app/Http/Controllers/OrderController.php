<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $orders = Order::query();

            return DataTables::of($orders)
                ->addColumn('action', function ($order) {
                    $viewUrl = route('admin.orders.show', $order->id);
                    return '<td class="text-center d-flex justify-content-center align-items-center">
                            <a href="' . $viewUrl . '" class="btn btn-sm btn-dark mr-1"><i class="fa fa-eye"></i></a>
                        </td>';
                })
                ->addColumn('name', function ($order) {
                    $name = $order->user->name;

                    return $name;
                })
                ->addColumn('gross_amount', function ($order) {
                    return 'Rp.' . number_format($order->gross_amount, 2, ',', '.');
                })
                ->addColumn('date', function ($order) {
                    return $order->created_at->format('d M Y H:i');
                })
                ->rawColumns(['action', 'name', 'gross_amount', 'date'])
                ->make(true);
        }
        return view('admin.order.index');
    }

    public function show(Order $order)
    {
        $items = $order->items;

        return view('admin.order.show', compact('items'));
    }

    public function export()
    {
        return new OrdersExport();
    }
}
