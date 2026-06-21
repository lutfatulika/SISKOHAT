<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginProcess(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Cek role dan tentukan redirect
            if ($user->role === 'admin') {
                return response()->json([
                    'success' => true,
                    'role' => 'admin',
                    'redirect' => '/admin',
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'role' => 'user',
                    'redirect' => '/index',
                    'user' => $user
                ]);
            }
        }

        // Login gagal
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}