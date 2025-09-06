<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah terotentikasi DAN memiliki role 'admin'
        // $request->user() akan berisi data user jika token valid
        if ($request->user() && $request->user()->role === 'admin') {
            // Jika ya, lanjutkan request ke controller
            return $next($request);
        }

        // Jika tidak, kirim response 403 Forbidden
        return response()->json([
            'message' => 'Akses ditolak. Anda tidak memiliki hak akses admin.'
        ], 403);
    }
}