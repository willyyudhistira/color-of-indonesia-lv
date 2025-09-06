<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\HomeCarouselItemController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\Admin\CarouselController;
use App\Http\Controllers\API\Admin\SponsorController;
use App\Http\Controllers\API\Admin\BannerController;
use App\Http\Controllers\API\Admin\MainEventController;
use App\Http\Controllers\API\HomePageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rute untuk Otentikasi
Route::post('/login', [AuthController::class, 'login']);

// Rute ini memerlukan user untuk login (menggunakan middleware auth:sanctum)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/home', [HomePageController::class, 'index']);

// RUTE ADMIN (dikelompokkan untuk keamanan dan keteraturan)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('carousels', CarouselController::class)->except(['show']);
    Route::apiResource('sponsors', SponsorController::class)->except(['show']);
    Route::apiResource('banners', BannerController::class)->except(['show']);
    Route::apiResource('testimonials', TestimonialController::class)->except(['show']);
    // MainEvent biasanya hanya ada 1 (singleton), jadi rutenya sedikit berbeda
    Route::get('main-event', [MainEventController::class, 'show']);
    Route::post('main-event', [MainEventController::class, 'update']);
});


Route::get('/events', [EventController::class, 'index']);

// Rute Admin
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'indexAdmin']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{event}', [EventController::class, 'show']); // Tambahkan jika perlu
    Route::post('/events/{event}', [EventController::class, 'update']); // Untuk update dengan file
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
});


Route::get('/programs', [ProgramController::class, 'index']);

// --- Rute Admin (perlu otentikasi & otorisasi) ---
// Kelompokkan semua rute admin di bawah middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    
    // GET /api/admin/programs (mendapatkan semua program)
    Route::get('/programs', [ProgramController::class, 'indexAdmin']);
    
    // POST /api/admin/programs (membuat program baru)
    Route::post('/programs', [ProgramController::class, 'store']);
    
    // GET /api/admin/programs/{program} (melihat detail satu program)
    Route::get('/programs/{program}', [ProgramController::class, 'show']);
    
    // PENTING: Untuk update dengan file, gunakan POST dengan _method=PUT/PATCH
    // POST /api/admin/programs/{program}
    Route::post('/programs/{program}', [ProgramController::class, 'update']);
    
    // DELETE /api/admin/programs/{program}
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);
});

Route::apiResource('testimonials', TestimonialController::class);

// Contoh untuk rute home carousel
Route::apiResource('home-carousel', HomeCarouselItemController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
