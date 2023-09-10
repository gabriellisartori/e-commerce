<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        try {
            $inputs = $request->validated();
            $user = User::where('email', $inputs['email'])->first();
            if (! $user || ! Hash::check($inputs['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['E-mail ou senha estão incorretos']
                ]);
            }
            
            $token = $user->createToken('token')->plainTextToken;
            
            return response()->json([
                'token' => $token
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao realizar login',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            //$request->bearerToken()
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao realizar logout',
            ], 401);
        }
    }

}