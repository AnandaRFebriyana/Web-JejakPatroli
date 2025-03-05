<?php

namespace App\Http\Middleware;

use App\Models\Guard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiGuardAuthenticate {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
    //     if (Auth::guard('guard')->check()) {
    //         return $next($request);
    //     }
        $token = $request->header('Authorization');
            if($token){
                $guard = Guard::where('token', $token)->first();
                
                if($guard){
                    Auth::guard('guard')->setUser($guard);
                    return $next($request);
                } else {
                    return response()->json(['error' => 'Invalid token'], 401);
                }
            }
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
