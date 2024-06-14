<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        $user->save();

        $token = $user->createToken('UserAuth')->plainTextToken;

        return response()->json(['token' => $token, 'name' => $user['name']], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' =>  Helpers::error_processor($validator)
            ], 403);
        }
        $data = [
            'name' => $request->name,
            'password' => $request->password
        ];


        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('UserAuth')->plainTextToken;
            $user = auth()->user();
            $user->save();

            return response()->json(['token' => $token, 'user' => $user['name']], 200);
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => "Credenciales Invalidas"]);
            return response()->json([
                'errors' => $errors
            ], 401);
        }
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
