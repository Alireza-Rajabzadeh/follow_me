<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        
        $request_token = $request->header('Authorization');

        $token = str_replace("Bearer ", "", $request_token);

        if ($token != env('TEST_TOKEN', "6GJTkxL4vLfp5xHRKwddBpO08TIiibdl0gP3tUkhR7DU8zlHwPuqdFc33DsoDzkW")) {

            return apiResponse(false, [], __('validation.un_authenticat'));
        }

        $user = User::find(1);

        Auth::login($user);
        

        return $next($request);
    }
}
