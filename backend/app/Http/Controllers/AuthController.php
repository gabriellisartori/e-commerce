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

            if (!$user || !Hash::check($inputs['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['E-mail ou senha estão incorretos']
                ]);
            }

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

            $expiresAt = now()->addMinutes(config('sanctum.expiration'));
            $token = $user->createToken('token', ['*'], $expiresAt)->plainTextToken;

            DB::commit();
            return response()->json([
                'token' => $token
            ], 200)->header('authorization', $token)
                ->header('Access-Control-Expose-Headers', 'Authorization');
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
            $token = explode('|', $request->bearerToken());
            DB::table('personal_access_tokens')
                ->where('token', hash('sha256', $token[1]))->delete();

            DB::commit();
            return response()->json([], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao realizar logout',
            ], 401);
        }
    }

    public function user(Request $request)
    {
        $token = explode('|', $request->bearerToken());
        $userId = DB::table('personal_access_tokens')
            ->where('token', hash('sha256', $token[1]))
            ->value('tokenable_id');

        $user = User::find($userId);
        if ($user) {

            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'Usuário não encontrado',
        ], 404);
    }
}
