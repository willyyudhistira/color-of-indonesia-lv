<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\FormIngestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute-rute ini untuk aplikasi eksternal atau frontend JavaScript.
| Semuanya secara otomatis memiliki prefix /api/.
|
*/
Route::post('/webhooks/certificate/muri', [FormIngestController::class, 'ingest']);
