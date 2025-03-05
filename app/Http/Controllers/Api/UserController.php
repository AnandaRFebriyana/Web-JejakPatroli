<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuardResource;
use App\Models\Guard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('guard')->attempt($credentials)) {
            $guard = Guard::where('email', $credentials['email'])->first();
            // $guard = Auth::guard('guard')->user();
            $token = Str::random(60);

            $guard->update(['token' => $token]);
            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token,
                'data' => new GuardResource($guard)
            ]);
        }
        return response()->json(['error' => 'Invalid email or password'], 401);
    }

    public function logout() {
        $guard = Auth::guard('guard')->user();

        if ($guard) {
            $guard->token = null;
            $guard->save();
        }
        Auth::guard('guard')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser() {
        $guard = Auth::guard('guard')->user();
        return new GuardResource($guard);
    }
}