<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSuratMasukController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

// ROUTE UNTUK SEMUA PENGGUNA (TANPA LOGIN)
Route::get('/', function () {
    $today = Carbon::today()->toDateString();
    $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

    return view('home', [
        'title' => 'Home',
        'visitorCount' => $visitorCount,
    ]);
});

Route::get('/berita', function () {
    $today = Carbon::today()->toDateString();
    $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

    $berita = \App\Models\Berita::latest()->paginate(6);

    return view('news', [
        'title' => 'Berita', 
        'berita' => $berita,
        'visitorCount' => $visitorCount
    ]);
})->name('berita');

Route::get('/berita/{slug}', function ($slug) {
    $today = Carbon::today()->toDateString();
    $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

    $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();

    return view('news-detail', [
        'title' => 'Detail Berita', 
        'berita' => $berita,
        'visitorCount' => $visitorCount
    ]);
})->name('berita.detail');

Route::get('/tentang', function () {
    $today = Carbon::today()->toDateString();
    $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

    return view('about', [
        'title' => 'Tentang',
        'visitorCount' => $visitorCount
    ]);
});

Route::get('/kontak', function () {
    $today = Carbon::today()->toDateString();
    $visitorCount = Visitor::where('visit_date', $today)->value('visit_count') ?? 0;

    return view('contact', [
        'title' => 'Kontak',
        'visitorCount' => $visitorCount
    ]);
});

// ROUTE UNTUK LOGIN DAN REGISTER
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ROUTE UNTUK KONFIRMASI EMAIL
// Rute untuk halaman notifikasi verifikasi
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Rute untuk memverifikasi email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if (!$request->user()) {
        return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu.');
    }
    
    $request->fulfill();

    // Mengarahkan ke dashboard berdasarkan role
    if ($request->user()->role == 'admin') {
        return redirect()->route('admin.dashboard')->with('message', 'Email berhasil diverifikasi.');
    } else {
        return redirect()->route('user.dashboard')->with('message', 'Email berhasil diverifikasi.');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

// Rute untuk mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Email verifikasi telah dikirim ulang.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Route untuk lupa password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ROUTE YANG MEMERLUKAN AUTENTIKASI
Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD UNTUK USER (PESERTA)
    Route::prefix('user')->name('user.')->middleware('user')->group(function () {

        // Dashboard User
        Route::get('dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        // Menu Profile
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Menu Activities
        Route::resource('activities', ActivityController::class);

        // Menu Surat Masuk
        Route::resource('surat-masuk', SuratMasukController::class);
    });

    // DASHBOARD UNTUK ADMIN (PEMBIMBING)
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
        
        // Dashboard Admin
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Menu Profile Admin
        Route::get('profile', [AdminController::class, 'index'])->name('profile.admin-user');
        Route::get('profile/create', [AdminController::class, 'create'])->name('profile.create');
        Route::post('profile', [AdminController::class, 'store'])->name('profile.store');
        Route::get('profile/{user}', [AdminController::class, 'show'])->name('profile.show');
        Route::get('profile/{user}/edit', [AdminController::class, 'edit'])->name('profile.edit');
        Route::put('profile/{user}', [AdminController::class, 'update'])->name('profile.update');
        Route::delete('profile/{user}', [AdminController::class, 'destroy'])->name('profile.destroy');

        // Menu Surat Masuk Admin
        Route::get('surat-masuk', [AdminSuratMasukController::class, 'index'])->name('surat-masuk.index');
        Route::get('surat-masuk/{surat_masuk}/edit', [AdminSuratMasukController::class, 'edit'])->name('surat-masuk.edit');
        Route::delete('surat-masuk/{surat_masuk}', [AdminSuratMasukController::class, 'destroy'])->name('surat-masuk.destroy');
        // Route untuk balas surat
        Route::post('surat-masuk/{id}/balas', [AdminSuratMasukController::class, 'balasSurat'])->name('surat-masuk.balas');

        // Menu Kelola Berita
        Route::resource('berita', AdminBeritaController::class)->parameters([
            'berita' => 'berita:slug'
        ]);

        // Route untuk statistik pengunjung
        Route::get('visitors', [VisitorController::class, 'showVisitorStats'])->name('visitors');
    });
});