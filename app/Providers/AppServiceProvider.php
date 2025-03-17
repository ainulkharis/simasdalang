<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom email verification template
        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email')
                ->line('Halo!')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.')
                ->action('Verifikasi Alamat Email', $verificationUrl)
                ->line('Jika Anda tidak membuat akun, tidak ada tindakan lebih lanjut yang diperlukan.')
                ->salutation('Salam, Tim Simasdalang');
        });

        // Custom reset password email template
        ResetPassword::toMailUsing(function ($notifiable, $resetUrl) {
            return (new MailMessage)
            ->subject('Reset Password')
            ->line('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->action('Reset Password', $resetUrl)
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Salam, Tim Simasdalang');
        });
    }
}