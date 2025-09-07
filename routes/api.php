<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\HomeCarouselItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute-rute ini untuk aplikasi eksternal atau frontend JavaScript.
| Semuanya secara otomatis memiliki prefix /api/.
|
*/

// --- RUTE OTENTIKASI API ---
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());


// --- RUTE API PUBLIK ---
Route::get('/home-page-data', [HomePageController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/programs', [ProgramController::class, 'index']);


// --- CONTOH API RESOURCE ---
// Endpoint ini bisa digunakan jika Anda punya React Admin Panel di masa depan
Route::apiResource('testimonials', TestimonialController::class);
Route::apiResource('home-carousel', HomeCarouselItemController::class);