<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        // 1. Ambil data yang sudah divalidasi oleh LoginRequest
        $credentials = $request->validated();

        // 2. Coba otentikasi user menggunakan Auth facade
        //    Fungsi Auth::attempt() sudah otomatis melakukan:
        //    - Mencari user berdasarkan email
        //    - Membandingkan hash password dari input dengan yang ada di database
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], Response::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // 3. Jika berhasil, ambil data user dan buat token Sanctum
        $user = User::where('email', $credentials['email'])->firstOrFail();
        
        // Hapus token lama jika ada dan buat yang baru
        $user->tokens()->delete();
        $token = $user->createToken('auth-token-'.$user->name)->plainTextToken;

        // 4. Kembalikan response yang sukses
        return response()->json([
            'message' => 'Otentikasi berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                // 'name' => $user->name, // Tambahkan 'name' di model jika ada
                'role' => $user->role,
            ]
        ]);
    }

    public function logout(): Response
    {
        // Hapus token yang sedang digunakan untuk request ini
        Auth::user()->currentAccessToken()->delete();

        return response()->noContent(); // 204 No Content
    }
}