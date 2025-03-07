<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSuratMasukController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Route untuk semua pengguna (tidak perlu login)
Route::get('/', function () {
    return view('home', [
        'title' => 'Home',
    ]);
});

// Route::get('/kegiatan', function () {
//     return view('posts', [
//         'title' => 'Kegiatan'
//     ]);
// });

Route::get('/tentang', function () {
    return view('about', [
        'title' => 'Tentang'
    ]);
});

Route::get('/kontak', function () {
    return view('contact', [
        'title' => 'Kontak'
    ]);
});

// Route untuk login dan register
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
    
    $request->fulfill(); // Tandai email sebagai terverifikasi

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

// Route yang memerlukan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard untuk User
    Route::prefix('user')->name('user.')->middleware('user')->group(function () {
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

    // Dashboard untuk Admin
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Dashboard Admin
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Menu Profile Admin
        Route::get('profile', [AdminController::class, 'index'])->name('profile.admin-user');
        Route::get('profile/create', [AdminController::class, 'create'])->name('profile.create');
        Route::post('profile', [AdminController::class, 'store'])->name('profile.store');
        Route::get('profile/{user}', [AdminController::class, 'show'])->name('profile.show');
        // Route::get('profile/{user}/edit', [AdminController::class, 'edit'])->name('profile.edit');
        // Route::put('profile/{user}', [AdminController::class, 'admin_update'])->name('profile.admin_update');
        Route::delete('profile/{user}', [AdminController::class, 'destroy'])->name('profile.destroy');

        // Rute untuk edit dan update profil admin
        Route::get('profile/{user}/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile/{user}', [AdminController::class, 'updateProfile'])->name('profile.update');

        // Menu untuk mengelola kegiatan peserta
        Route::get('activities/{activity}/edit', [AdminController::class, 'editActivity'])->name('activities.edit');
        Route::put('activities/{activity}', [AdminController::class, 'updateActivity'])->name('activities.update');

        // Menu Surat Masuk Admin
        Route::get('surat-masuk', [AdminSuratMasukController::class, 'index'])->name('surat-masuk.index');
        Route::get('surat-masuk/{surat_masuk}/edit', [AdminSuratMasukController::class, 'edit'])->name('surat-masuk.edit');
        Route::delete('surat-masuk/{surat_masuk}', [AdminSuratMasukController::class, 'destroy'])->name('surat-masuk.destroy');

        Route::post('surat-masuk/{id}/balas', [AdminSuratMasukController::class, 'balasSurat'])->name('surat-masuk.balas');

        // Route::resource('surat-masuk', AdminSuratMasukController::class)->except(['show', 'destroy']);
        // Penjelasan: except(['show', 'destroy']) berarti hanya membuat route yang umum digunakan, kecuali show dan destroy.
    });
});