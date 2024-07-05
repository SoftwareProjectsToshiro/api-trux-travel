<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\CentralLogics\Helpers;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'package_id' => 'required',
            'reservation_date' => 'required',
            'number_of_passengers' => 'required',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        };

        $reservation = new Reservation();
        $reservation->id = 100000 + Reservation::all()->count() + 1;
        $reservation->user_id = $request->user_id;
        $reservation->package_id = $request->package_id;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->number_of_passengers = $request->number_of_passengers;
        $reservation->payment_method = $request->payment_method;
        $reservation->payment_status = $request->payment_status;
        $reservation->status = $request->status;
        $reservation->save();

        Comment::create([
            'tour_package_id' => $request->package_id,
            'user_id' => $request->user_id,
            'content' => '',
            'title' => $reservation->package->nombre,
            'rating' => 0,
        ]);

        $msg = 'Reserva creada con éxito.';
        return response()->json(['msg' => $msg,'reservation_id' => $reservation->id], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
