<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        DB::beginTransaction();
        try {
            $inputs = $request->validated();
            $user = User::where('email', $inputs['email'])->first();
            if (! $user || ! Hash::check($inputs['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['E-mail ou senha estão incorretos']
                ]);
            }
            
            $token = $user->createToken('token')->plainTextToken;
            
            DB::commit();
            return response()->json([
                'token' => $token
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao realizar login',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        DB::beginTransaction();
        try {
            //$request->bearerToken()
            $request->user()->currentAccessToken()->delete();
            
            DB::commit();
            return response()->json([], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao realizar logout',
            ], 401);
        }
    }

}