<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
        
        $msg = $request->nombre . ' ' . $request->apellido . ' actualizado correctamente.';
        $user = User::findOrFail($id);
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;

        if($user->email != $request->email) {
            try{
                $data = [
                    'email' => $user->email,
                    'new_email' => $request->email,
                ];
                $client = new Client();
                $response = $client->request('POST', 'https://integraciones-app-cjzse57yha-uc.a.run.app/api/v1/update-email', [
                    'json' => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                ]);

            } catch (ClientException $e) {
                return response()->json([
                    'errors' => [
                        ['code' => 'email', 'message' => 'Email ya registrado.']
                    ]
                ], 403);
            }
    
            $msg = json_decode($response->getBody()->getContents(), true)['msg'];

            $user->email = $request->email;
        }

        $user->phone = $request->phone;
        $user->save();

        return response()->json(['msg' => $msg], 200);
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
