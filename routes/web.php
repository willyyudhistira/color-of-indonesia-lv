<?php

use App\Http\Controllers\Admin\HomeCarouselController;
use App\Http\Controllers\Admin\MainEventController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SponsorBannerController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EventController as AdminEventController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\ContactPageController;
use App\Http\Controllers\Web\GalleryController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\SponsorshipController;
use App\Http\Controllers\Web\EventController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ===============================================
// RUTE OTENTIKASI (LOGIN, REGISTER, LOGOUT)
// ===============================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'store'])->name('login.store')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.store')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//VISITORS PAGES
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/gallery/{album:slug?}', [GalleryController::class, 'index'])->name('gallery');
Route::get('/sponsorship', [SponsorshipController::class, 'index'])->name('sponsorship');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contact', [ContactPageController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactPageController::class, 'store'])->name('contact.store');

// ===============================================
// GRUP RUTE UNTUK ADMIN DASHBOARD
// ===============================================
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.') // Menambahkan prefix nama rute
    ->group(function () {
    
    // Rute utama '/admin/dashboard' sekarang menjadi halaman manajemen carousel
    Route::get('/dashboard', [HomeCarouselController::class, 'index'])->name('dashboard');

    // Rute untuk operasi (create, edit, update, delete) carousel
    // Kita gunakan prefix '/home-carousel' agar lebih jelas
    Route::prefix('home-carousel')->name('home.')->group(function () {
        Route::post('/', [HomeCarouselController::class, 'store'])->name('store');
        Route::get('/{item}/edit', [HomeCarouselController::class, 'edit'])->name('edit');
        Route::put('/{item}', [HomeCarouselController::class, 'update'])->name('update');
        Route::delete('/{item}', [HomeCarouselController::class, 'destroy'])->name('destroy');
    });

    Route::resource('programs', ProgramController::class);
    Route::resource('main-events', MainEventController::class);
    Route::resource('events', AdminEventController::class);

    // Rute khusus untuk foto
    Route::post('gallery/{gallery}/photos', [AdminGalleryController::class, 'uploadPhoto'])->name('gallery.photos.upload');
    Route::delete('gallery/photos/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('gallery.photos.destroy');

    // Rute resource untuk Album
    Route::resource('gallery', AdminGalleryController::class);

    // Rute untuk Sponsor Management (halaman utama)
    Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');

    // Rute resource untuk Sponsor (Logo) & Sponsor Banner
    Route::resource('sponsors', SponsorController::class)->except(['index']);
    Route::resource('sponsor-banners', SponsorBannerController::class);

    Route::resource('news', AdminNewsController::class);

    Route::resource('testimonials', TestimonialController::class);

    // Nanti tambahkan rute-rute admin lain di sini
    // Contoh: Route::resource('programs', ProgramAdminController::class);
});

