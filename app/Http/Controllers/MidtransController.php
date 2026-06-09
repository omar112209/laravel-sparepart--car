<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function createTransaction(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'User',
                'email' => 'user@gmail.com',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'token' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
