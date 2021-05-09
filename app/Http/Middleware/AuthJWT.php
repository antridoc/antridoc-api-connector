<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;
use Firebase\JWT\JWT;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($jwt = $request->bearerToken()) {
            $claims = JWT::decode($jwt, config("jwt.secret"), ['HS256']);

            if ($claims) {
                return $next($request);
            }
        }

        return \response()->json(["status" => Response::HTTP_UNAUTHORIZED, "message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
    }
}
