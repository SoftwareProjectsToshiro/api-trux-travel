<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tourist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\Validator;

class TouristController extends Controller
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
            'user_email' => 'required',
            'dni' => 'required',
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'sexo' => 'required',
            'email' => 'required|unique:users,email',
            'telefono' => 'required|unique:users,phone',
            'fecha_nacimiento' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        };

        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $msg = $request->nombre . ' ' . $request->apellido_paterno . ' ' . $request->apellido_materno . ' has been created';

        $tourist = new Tourist();
        $tourist->dni = $request->dni;
        $tourist->nombre = $request->nombre;
        $tourist->apellido_paterno = $request->apellido_paterno;
        $tourist->apellido_materno = $request->apellido_materno;
        $tourist->sexo = $request->sexo;
        $tourist->email = $request->email;
        $tourist->telefono = $request->telefono;
        $tourist->fecha_nacimiento = $request->fecha_nacimiento;
        $tourist->save();

        $tourist->users()->attach($request->user_id);

        return response()->json(['msg' => $msg], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Tourist $tourist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tourist $tourist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tourist $tourist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tourist $tourist)
    {
        //
    }
}
