<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyEstablishmentUser
{
    /**
     * Handle an incoming request.
     *
     * @return \Illuminate\Http\Response|Closure
     */
    public function handle(Request $request, Closure $next)
    {
        if (($user = auth()->user()) && ! $user->establishment_id) {
            return response([
                'error' => 'Acesso não autorizado.',
            ], 401);
        }

        return $next($request);
    }
}