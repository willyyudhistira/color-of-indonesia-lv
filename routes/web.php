<?php

use App\Http\Controllers\Admin\CertificateTemplateController;
use App\Http\Controllers\Admin\HomeCarouselController;
use App\Http\Controllers\Admin\MainEventController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SponsorBannerController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;

use App\Http\Controllers\Web\ECertificateController;
use App\Http\Controllers\Web\VideoController as WebVideoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\ContactPageController;
use App\Http\Controllers\Web\GalleryController as WebGalleryController; // <-- Beri alias
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
Route::get('/generate', function(){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

// Route::get('/', [HomeController::class, 'showUnderConstruction'])->name('under-construction');

// ===============================================
// RUTE OTENTIKASI (LOGIN, REGISTER, LOGOUT)
// ===============================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'store'])->name('login.store')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.store')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//VISITORS PAGES
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/gallery', [WebGalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{album:slug}', [WebGalleryController::class, 'show'])->name('gallery.show');
Route::get('/sponsorship', [SponsorshipController::class, 'index'])->name('sponsorship');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contact', [ContactPageController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactPageController::class, 'store'])->name('contact.store');
Route::get('/videos', [WebVideoController::class, 'index'])->name('videos.index');

// Route::get('/e-certificate', [ECertificateController::class, 'index'])->name('e-certificate.index');
// Route::post('/e-certificate', [ECertificateController::class, 'generate'])->name('e-certificate.generate');
// Route::get('/verify-certificate/{certificate_number}', [ECertificateController::class, 'verify'])->name('certificate.verify');
// Route::get('/certificate-preview/{event}', [ECertificateController::class, 'preview'])->name('certificate.preview'); // <-- INI RUTE YANG BENAR

Route::get('/e-certificate', [ECertificateController::class, 'index'])->name('e-certificate.index');

// Rute 'POST' (.generate) tidak diperlukan lagi karena pencarian sekarang menggunakan 'GET' di .index
// Route::post('/e-certificate', [ECertificateController::class, 'generate'])->name('e-certificate.generate');

// TAMBAHKAN RUTE INI UNTUK TOMBOL DOWNLOAD
Route::get('/e-certificate/download/{participant}', [ECertificateController::class, 'download'])->name('e-certificate.download');
Route::get('/verify-certificate/{certificate_number}', [ECertificateController::class, 'verify'])->name('certificate.verify');

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
    //Export report
    Route::get('/events/export', [AdminEventController::class, 'export'])->name('events.export');
    Route::resource('programs', ProgramController::class);
    Route::resource('main-events', MainEventController::class);
    Route::resource('events', AdminEventController::class);

    // Rute khusus untuk foto
    Route::post('gallery/{gallery}/photos', [AdminGalleryController::class, 'uploadPhoto'])->name('gallery.photos.upload');
    Route::delete('gallery/photos/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('gallery.photos.destroy');

    // Rute resource untuk Album
    Route::post('gallery/{gallery}/photos', [AdminGalleryController::class, 'uploadPhoto'])->name('gallery.photos.upload');
    Route::delete('gallery/photos/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('gallery.photos.destroy');
    Route::resource('gallery', AdminGalleryController::class);

    Route::resource('videos', AdminVideoController::class);

    // Rute untuk Sponsor Management (halaman utama)
    Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');

    // Rute resource untuk Sponsor (Logo) & Sponsor Banner
    Route::resource('sponsors', SponsorController::class)->except(['index']);
    Route::resource('sponsor-banners', SponsorBannerController::class);

    Route::resource('news', AdminNewsController::class);

    Route::resource('testimonials', TestimonialController::class);

    Route::resource('participants', ParticipantController::class);
    Route::post('/participants/import', [ParticipantController::class, 'import'])->name('participants.import');
    Route::get('/participants/{participant}/download', [ParticipantController::class, 'downloadCertificate'])->name('participants.downloadCertificate');
    Route::get('/participants/{participant}/print', [ParticipantController::class, 'printCertificate'])->name('participants.printCertificate');
    Route::patch('/participants/{participant}/notes', [ParticipantController::class, 'updateNote'])->name('participants.updateNote');

    Route::get('/certificate-template', [CertificateTemplateController::class, 'edit'])->name('certificate-template.edit');
    Route::put('/certificate-template', [CertificateTemplateController::class, 'update'])->name('certificate-template.update');
    Route::get('/certificate-templates/{certificate_template}/preview', [CertificateTemplateController::class, 'preview'])->name('certificate-templates.preview');
    Route::get('/certificate-templates/{template}/download', [CertificateTemplateController::class, 'download'])->name('certificate-templates.download');
    Route::resource('certificate-templates', CertificateTemplateController::class);

    // Rute ini sekarang akan menerima event yang ingin dipratinjau
    // Route::get('/e-certificate', [ECertificateController::class, 'index'])->name('e-certificate.index');
    // Route::post('/e-certificate', [ECertificateController::class, 'generate'])->name('e-certificate.generate');
    // Route::get('/verify-certificate/{certificate_number}', [ECertificateController::class, 'verify'])->name('certificate.verify');

    // ## TAMBAHKAN BARIS INI ##
    Route::get('/certificate-preview/{event}', [ECertificateController::class, 'preview'])->name('certificate.preview');

    Route::get('/events/{event}/template', [AdminEventController::class, 'editTemplate'])->name('events.template.edit');
    Route::put('/events/{event}/template', [AdminEventController::class, 'updateTemplate'])->name('events.template.update');









    // Route::resource('certificate-templates', CertificateTemplateController::class);



    // Nanti tambahkan rute-rute admin lain di sini
    // Contoh: Route::resource('programs', ProgramAdminController::class);


});

