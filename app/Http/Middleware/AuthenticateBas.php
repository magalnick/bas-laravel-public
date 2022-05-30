<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Response;
use App\Utilities\Hash;
use App\Models\Database\User;

class AuthenticateBas
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
        $token     = trim($request->getUser());
        $auth_time = trim($request->getPassword());
        $time      = time();

        if ($token === '' || $auth_time === '') {
            return Response::error("No authentication token specified", 400);
        }
        if (intval($auth_time) < $time) {
            return Response::error("Authentication token expired", 401);
        }

        $user = (new User())->authenticateByToken($token, $auth_time);
        if (is_null($user)) {
            return Response::error("Unable to authenticate token: {$token}", 401);
        }

        $request->merge(
            [
                'user'  => $user,
                'token' => $token,
            ]
        );

        return $next($request);
    }
}
