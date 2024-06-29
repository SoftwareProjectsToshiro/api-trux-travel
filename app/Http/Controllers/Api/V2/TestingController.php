<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Reservation;

class TestingController extends Controller
{
    public function index()
    {
        $packageId = 1;
        $userId = 1;
        $reservation = Reservation::with(['package'])
            ->where('package_id', $packageId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $packagePrice = $reservation->package->precio;

        $numberOfTourists = $reservation->number_of_passengers;

        $totalPrice = $packagePrice * $numberOfTourists;

        return response()->json([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'package_id' => $reservation->package_id,
            'package_price' => $packagePrice,
            'number_of_tourists' => $numberOfTourists,
            'total_price' => $totalPrice,
        ], 200);
    }
}
