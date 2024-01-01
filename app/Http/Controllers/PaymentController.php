<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;


class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $api_key = env('RAZORPAY_KEY');
        $api_secret = env('RAZORPAY_SECRET');

        $api = new Api($api_key, $api_secret);

        $generate = $api->order->create([
            'amount' => $request->amount,
            'currency' => 'INR', 
            'payment_capture' => 1,
        ]);

        $order = array(
           
           'id' => $generate->id,
           'amount' => $generate->amount,
           'currency' => $generate->currency
        );
        return json_encode($order, true);
    }

    public function paymentCallback(Request $request)
    {
        
        return response()->json(['status' => 'success']);
        
    }
}
