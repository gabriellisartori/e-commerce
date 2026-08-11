<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyEstablishmentUser
{
    /**
     * Handle an incoming request.
     *
     * @return \Illuminate\Http\Response|Closure
     */
    public function handle(Request $request, Closure $next)
    {
        $token = explode('|', $request->bearerToken());
        $userId = DB::table('personal_access_tokens')
            ->where('token', hash('sha256', $token[1]))
            ->value('tokenable_id');

        $user = User::find($userId);
        if ($user && ! $user->establishment_id && ! $user->is_admin) {
            return response([
                'error' => 'Acesso não autorizado.',
            ], 401);
        }

        return $next($request);
    }
}