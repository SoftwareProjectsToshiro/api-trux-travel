<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $client = new Client();
        $response = $client->request('POST', 'https://integraciones-app-cjzse57yha-uc.a.run.app/api/v1/register', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/json'
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if($statusCode != 200){
            return response()->json(['error' => 'Error en la integración'], 500);
        }

        $msg = json_decode($response->getBody()->getContents(), true)['msg'];

        $user = new User();
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();

        return response()->json(['msg' => $msg], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' =>  Helpers::error_processor($validator)
            ], 403);
        }
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $client = new Client();
        $response = $client->request('POST', 'https://integraciones-app-cjzse57yha-uc.a.run.app/api/v1/login', [
            'json' => $data,
            'headers' => [
                'Accept' => 'application/json'
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200){
            return response()->json(['error' => 'Error en la integración'], 500);
        }

        $token = json_decode($response->getBody()->getContents(), true);
        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => ['Correo electrónico no encontrado.']
                ]
            ], 403);
        }

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'code' => 'auth-002',
            'message' => 'Token válido.'
        ], 200);
    }

    public function verifyToken(Request $request)
    {
        return response()->json(['message' => 'Token válido.'], 200);
    }
}
