<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller {

    public function landingpage() {
        return view("pages.landingpage");
    }

    public function landingabout() {
        return view("pages.landingabout");
    }

    public function signin() {
        return view("pages.auth.sign-in");
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ],[
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.'
        ]);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            // Email tidak ditemukan
            return back()->withInput($request->only('email'))->with('error', 'Email salah');
        }

        if (!Hash::check($request->password, $user->password)) {
            // Password salah
            return back()->withInput($request->only('email'))->with('error', 'Password salah');
        }

        // Jika email dan password cocok, login
        Auth::guard('admin')->login($user);
        return redirect('/dashboard')->with('success', 'Login berhasil!');
    }

    public function logout() {
        session()->flush();
        Auth::guard('admin')->logout();
        return redirect('/login');
    }
}
