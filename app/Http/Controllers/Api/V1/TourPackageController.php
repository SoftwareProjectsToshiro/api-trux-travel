<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

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

    public function get_all_package(Request $request)
    {
        $package = TourPackage::where('isActived', 1)->get();
        return response()->json($package, 200);
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

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        };

        $package = new TourPackage();
        $package->name = $request->name;
        $package->description = $request->description;
        $package->tipo_paquete = $request->tipo_paquete;
        $package->precio = $request->precio;
        $package->imagen = $request->imagen;
        $package->save();

        return response()->json($package, 200);
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
