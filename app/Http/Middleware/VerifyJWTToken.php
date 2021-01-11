<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Throwable;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = config('jwt.secret_key');
        try {
            JWT::decode($request['token'], config('jwt.secret_key'), array('HS256'));
            return $next($request);
        } catch (\throwable $e) {
            return response()->json("permission denided");
        }
    }
}
