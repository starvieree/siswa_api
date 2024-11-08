<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        try {
            $user = User::create([
                'name' => $validateData(['name']),
                'email' => $validateData(['email']),
                'password' => $validateData(['password'])
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Registrasi Gagal, Silahkan Coba Lagi.'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attemp($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid Login Details'
            ], 401);
        }

        try {
            $user = User::where('email', $request['email'])->firstOrFaill();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Login Gagal, Silahkan Coba Lagi.'
            ], 500);
        }
    }
}
