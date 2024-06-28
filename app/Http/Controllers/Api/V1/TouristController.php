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
    public function index(Request $request, $doc)
    {
        $tourist = Tourist::where('documento_identidad', $doc)->first();
        if (!$tourist) {
            return response()->json(['errors' => [
                ['code' => 'documento_identidad', 'message' => 'Nuevo turista detectado, por favor registre sus datos.']
            ]], 404);
        }

        return response()->json($tourist, 200);
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
            'tour_package_id' => ['required', 'exists:tour_packages,id'],
            'tipo_documento' => ['required', 'string'],
            'documento_identidad' => ['required', 'string'],
            'nombre' => ['required', 'string'],
            'apellido_paterno' => ['required', 'string'],
            'apellido_materno' => ['required', 'string'],
            'sexo' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'telefono' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'user_email' => ['required', 'string', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        };

        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            return response()->json(['errors' => [
                ['code' => 'user_email', 'message' => 'Usuario no encontrado']
            ]], 404);
        }

        $tourist = Tourist::where('documento_identidad', $request->documento_identidad)->first();

        $msg = 'Registro exitoso';

        if (!$tourist) {
            $msg = $request->nombre . ' ' . $request->apellido_paterno . ' ' . $request->apellido_materno . ' ha sido registrado correctamente.';
            $tourist = new Tourist();
            $tourist->tipo_documento = $request->tipo_documento;
            $tourist->documento_identidad = $request->documento_identidad;
            $tourist->nombre = $request->nombre;
            $tourist->apellido_paterno = $request->apellido_paterno;
            $tourist->apellido_materno = $request->apellido_materno;
            $tourist->sexo = $request->sexo;
            $tourist->email = $request->email;
            $tourist->telefono = $request->telefono;
            $tourist->fecha_nacimiento = $request->fecha_nacimiento;
            $tourist->save();

            $user->tourists()->attach($tourist->id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $tourist->tourPackages()->attach($request->tour_package_id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
