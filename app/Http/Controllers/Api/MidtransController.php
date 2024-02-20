<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\MidtransHistory;
use App\Models\Order;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            // update transaction status
            if ($transactionStatus == 'settlement') {
                $order->status = OrderStatusEnum::SUCCESS->value;
            } else if ($transactionStatus == 'expire') {
                $order->status = OrderStatusEnum::FAILED->value;
            }

            $order->payment_type = $payload['payment_type'];
            $order->save();
        } catch (Error $err) {
            throw $err;
        }

        return response()->json(['message' => 'success']);
    }
}
