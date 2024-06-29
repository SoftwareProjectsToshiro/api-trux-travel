<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;

class TestingController extends Controller
{
    public function index()
    {
        $order_id = 1;
        $package = TourPackage::with(['reservations', 'tourists'])
            ->findOrFail($order_id);

        $packagePrice = $package->precio;
        $numberOfTourists = $package->tourists->count();
        $totalPrice = $packagePrice * $numberOfTourists;

        return response()->json([
            'totalPrice' => $totalPrice
        ], 200);
    }
}
