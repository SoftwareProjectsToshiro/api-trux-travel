<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Reservation;

class TestingController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Hello from TestingController@index',
            'data' => 'This is a test data'
        ]);
    }
}
