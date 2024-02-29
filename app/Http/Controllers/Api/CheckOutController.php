<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewOrderNotification;

class CheckOutController extends Controller
{
    public function checkOut(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $items = $cart->items;

        $itemDetails = [];
        $totalPrice = 0;

        // mapping each items on cart
        foreach ($items as $item) {
            $grossAmount = $item->product->price * $item->quantity;
            $totalPrice += $grossAmount;

            $itemDetails[] = [
                'id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name
            ];
        }

        $order = Order::create([
            'id' => rand(1000, 9999),
            'user_id' => $user->id,
            'status' => OrderStatusEnum::PENDING->value,
            'gross_amount' => $totalPrice,
            'snap_token' => 'x',
            'snap_url' => 'x'
        ]);

        $orderItem = [];
        foreach ($items as $item) {
            $orderItem[] = [
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
            ];
        }

        OrderItem::insert($orderItem);

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'last_name' => '',
                'email' => $user->email,
                'phone' => $user->phone_number,
            ],
            'item_details' => $itemDetails
        ];

        $snapTrans = $this->hitMidtrans($params);

        $order->snap_token = $snapTrans->token;
        $order->snap_url = $snapTrans->redirect_url;

        $order->save();

        $cart->delete();

        // notify admins
        $admins = User::where('role', UserRoleEnum::ADMIN->value)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }

        return response()->json(['snap transaction' => $snapTrans]);
    }

    private function hitMidtrans($params)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $snapTrans = Snap::createTransaction($params);
        return $snapTrans;
    }
}
