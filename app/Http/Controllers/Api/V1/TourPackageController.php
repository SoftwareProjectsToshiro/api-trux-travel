<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required',
            'description' => 'required',
            'tipo_paquete' => 'required',
            'precio' => 'required',
            'imagen' => 'required'
        ]);

        $tour = Tour::create($validator);

        return response()->json($tour, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TourPackage $tourPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourPackage $tourPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        //
    }
}