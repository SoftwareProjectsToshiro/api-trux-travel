<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Models\Reservation;
use App\Models\TourPackage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NiubizPaymentController extends Controller
{
    public function viewNiubiz(Request $request, $order_id, $user_id)
    {

        try{
            $reservation = Reservation::with(['package'])
                ->where('package_id', $order_id)
                ->where('user_id', $user_id)
                ->firstOrFail();
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Reservation not found'
            ], 404);
        }

        $packagePrice = $reservation->package->precio;

        $numberOfTourists = $reservation->number_of_passengers;

        $totalPrice = $packagePrice * $numberOfTourists;

        $code = "integraciones@niubiz.com.pe" . ':' . "_7z3@8fF";
        $encodedCode = base64_encode($code);
        $merchantId = 456879852;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://apitestenv.vnforapps.com/api.security/v1/security', [
            'headers' => [
                'accept' => 'text/plain',
                'authorization' => 'Basic '.$encodedCode,
            ],
        ]);

        $response_token = $response->getBody();

        $response_sesion_token = $client->request('POST', 'https://apisandbox.vnforappstest.com/api.ecommerce/v2/ecommerce/token/session/'.$merchantId, [
            'headers' => [
                'Authorization' => (string) $response_token,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                "channel"=>"web",
                "amount"=>$totalPrice,
            ]),
        ]);

        $response_session = $response_sesion_token->getBody();
        $session_key = json_decode($response_session)->sessionKey;

        return view('pay-niubiz', compact('session_key', 'merchantId', 'response_token', 'reservation','totalPrice'));
    }

    public function success(Request $request, $order_id, $user_id)
    {
        try{
            $reservation = Reservation::with(['package'])
                ->where('package_id', $order_id)
                ->where('user_id', $user_id)
                ->firstOrFail();
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Reservation not found'
            ], 404);
        }

        $packagePrice = $reservation->package->precio;

        $numberOfTourists = $reservation->number_of_passengers;

        $totalPrice = $packagePrice * $numberOfTourists;

        $transactionToken = $request->transactionToken;
        $response = new \GuzzleHttp\Client();
        $merchantId = 456879852;
        $response = $response->request('POST', 'https://apisandbox.vnforappstest.com/api.authorization/v3/authorization/ecommerce/'.$merchantId, [
            'headers' => [
                'Authorization' => $request->_token,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                "captureType" => "manual",
                "channel" => "web",
                "countable" => true,
                "order" => [
                    "amount" => $totalPrice,
                    "currency" => "PEN",
                    "purchaseNumber" => $order_id,
                    "tokenId" => $transactionToken
                ]
            ]),
        ]);

        $response = json_decode($response->getBody());

        if($response->dataMap->ACTION_CODE == "000"){
            $reservation_update = Reservation::find($order_id);
            $reservation_update->isPaid = true;
            $reservation_update->payment_status = 'Paid';
            $reservation_update->status = 'Reservado';
            $reservation_update->save();
            return redirect()->route('payment-success');
        } else {
            return redirect()->route('payment-fail');
        }
    }

    public function fail()
    {
        DB::table('orders')
            ->where('id', session('order_id'))
            ->update(['order_status' => 'failed',  'payment_status' => 'unpaid', 'failed'=>now()]);
        $order = Order::find(session('order_id'));
        if ($order->callback != null) {
            return redirect($order->callback . '&status=fail');
        }
        return \redirect()->route('payment-fail');
    }
}
