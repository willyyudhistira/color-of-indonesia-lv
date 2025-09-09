<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Exceptions\PostTooLargeException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        // 2. TAMBAHKAN BLOK KODE INI
        // Blok ini akan dijalankan khusus ketika terjadi error PostTooLargeException
        $this->renderable(function (PostTooLargeException $e, $request) {
            // Ambil batas ukuran file dari konfigurasi PHP Anda untuk pesan yang dinamis
            $maxSize = ini_get('post_max_size');

            // Redirect pengguna kembali ke halaman sebelumnya dengan pesan error
            return back()->with('error', "Ukuran file terlalu besar! Batas unggah maksimal adalah {$maxSize}.");
        });
    }
}
