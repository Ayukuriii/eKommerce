<?php

namespace App\Http\Controllers\Api;

use Error;

use App\Models\User;
use App\Models\Order;

use App\Models\Product;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Enums\OrderStatusEnum;
use App\Models\MidtransHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\MidtransNotification;

class MidtransController extends Controller
{
    public function handlePayment(Request $request)
    {
        // tampung callback dari midtrans
        $payload = $request->all();

        Log::info($payload);

        try {
            $orderId = $payload['order_id'];
            $statusCode = $payload['status_code'];
            $grossAmount = $payload['gross_amount'];
            $signatureKey = $payload['signature_key'];
            $serverKey = config('midtrans.server_key');

            $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            // check signature
            if ($signature != $signatureKey) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $transactionStatus = $payload['transaction_status'];

            MidtransHistory::create([
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'payload' => json_encode($payload)
            ]);

            $order = Order::find($orderId);
            if (!$order) {
                return response()->json([
                    'message' => 'Invalid order / Order not found!'
                ], 404);
            }

            $user = $order->user;

            // update transaction status
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $order->status = OrderStatusEnum::SUCCESS->value;
                $items = $order->items;
                foreach ($items as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    $product->update([
                        'quantity' => $product->quantity - $item->quantity
                    ]);
                }
            } else if ($transactionStatus == 'expire' || $transactionStatus == 'failure' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                $order->status = OrderStatusEnum::FAILED->value;
            }

            $order->payment_type = $payload['payment_type'];
            $order->save();

            // notify user / admins
            $admins = User::where('role', UserRoleEnum::ADMIN->value)->get();
            if ($order->status !== 'pending') {
                $this->statusUpdateNotification($order, $user);

                foreach ($admins as $admin) {
                    $this->statusUpdateNotification($order, $admin);
                }
            }
        } catch (Error $err) {
            throw $err;
        }

        return response()->json(['message' => 'success']);
    }

    public function statusUpdateNotification($order, $user)
    {
        $user->notify(new MidtransNotification($order));
    }
}
