<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://us-central1-reactwebapp-bf5ca.cloudfunctions.net/app/api/v2/comments', [
            'headers' => [
                'accept' => 'application/json',
            ],
        ]);

        $response = json_decode($response->getBody());
        $comments = $response->comments;
        return view('payment-view', compact('comments'));
//        return response()->json(['errors' => ['code' => 'order-payment', 'message' => 'Data not found']], 403);
    }

    public function success()
    {
        $callback = null;

//        $order = Order::where(['id' => session('order_id'), 'user_id'=>session('customer_id')])->first();

//        if(isset($order)) $callback = $order->callback;

        if ($callback != null) {
            return redirect(true . '&status=success');
        }
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    public function fail()
    {
        $callback = null;

        $order = Order::where(['id' => session('order_id'), 'user_id'=>session('customer_id')])->first();

        if(isset($order)) $callback = $order->callback;

        if ($callback != null) {
            return redirect($order->callback . '&status=fail');
        }
        return response()->json(['message' => 'Payment failed'], 403);
    }
}
