<?php

namespace App\Http\Middleware;

use App\Models\VisitorCounter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountVisitorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengunjung ini sudah dihitung dalam sesi ini
        if (!session()->has('visitor_counted')) {
            // Ambil data counter, atau buat baru jika belum ada sama sekali
            $counter = VisitorCounter::firstOrCreate(['id' => 1], ['count' => 0]);

            // Tambah hitungan
            $counter->increment('count');

            // Tandai bahwa sesi ini sudah dihitung
            session(['visitor_counted' => true]);
        }

        return $next($request);
    }
}