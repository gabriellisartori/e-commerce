<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $inputs = $request->validate();
        $user = User::where('email', $inputs['email'])->first();
        if (! $user || ! Hash::check($inputs['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['E-mail ou senha estão incorretos']
            ]);
        }

        $token = $user->createToken()->plainTextToken;

        return response()->json([
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        //$request->bearerToken()
        $request->user()->currentAccessToken()->delete();

        return response()->json([], 200);
    }

}