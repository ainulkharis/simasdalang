<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Services\EmailValidationService;

class AuthController extends Controller
{
    // Method untuk menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Method untuk proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Proses autentikasi
        $credentials = $request->only('email', 'password');

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika email tidak terdaftar, tampilkan pesan error
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->onlyInput('email');
        }

        // Jika email terdaftar, cek password
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Mengarahkan user berdasarkan role
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard'); // Dashboard Admin
            } else {
                return redirect()->route('user.dashboard'); // Dashboard User
            }
        }

        return back()->withErrors([
            'password' => 'Password salah.',
        ])->onlyInput('email');
    }


    // Method untuk menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Method untuk proses register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ],[
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set role default ke 'user'
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        // Otomatis login setelah registrasi
        Auth::login($user);

        return redirect()->route('verification.notice')->with('message', 'Silahkan periksa email Anda untuk verifikasi.');
    }

    // Method untuk menampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Method untuk mengirim link reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Buat token reset password
        $token = Password::createToken($user);

        // Kirim email reset password
        $user->sendPasswordResetNotification($token);

        session()->flash('status', 'Link reset password telah dikirim ke alamat email Anda. Silahkan periksa <strong>kotak masuk</strong> atau <strong>folder spam</strong> pada email Anda.');
        return back();
    }

    // Method untuk menampilkan form reset password
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    // Method untuk reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ],[
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }

}
