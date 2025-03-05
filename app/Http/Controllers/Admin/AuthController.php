<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function signin() {
        return view("pages.auth.sign-in");
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ],[
            'email' => 'Email harus diisi.',
            'password' => 'Password harus diisi.'
        ]);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect('/dashboard');
        }
        return back()->withInput($request->only('email'))->with('error', 'Email atau Password salah!');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
