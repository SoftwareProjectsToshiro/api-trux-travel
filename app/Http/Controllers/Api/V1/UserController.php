<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users
        $users = User::all();
        return response()->json($users, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $email)
    {

        $user = User::where('email', $email)->first();
        
        if($user == null) {
            return response()->json([
                'errors' => [
                    ['code' => 'email', 'message' => 'Not Found']
                ]
            ], 403);
        }
        return response()->json($user, 200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' =>  Helpers::error_processor($validatedData)
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->update();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function desactive_user(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->isActived = false;
        $user->save();

        return response()->json($user, 200);
    }
}
