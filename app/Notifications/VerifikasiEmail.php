<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;


class VerifikasiEmail extends Notification
{
    public function __construct()
    {
        // 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generate URL verifikasi dengan tanda tangan digital
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        return (new MailMessage)
            ->subject('Verifikasi Alamat Email')
            ->greeting('Halo!')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.')
            ->action('Verifikasi Alamat Email', $verificationUrl)
            ->line('Jika Anda tidak pernah merasa membuat akun, Anda dapat mengabaikan email ini.')
            ->salutation('Salam, Tim Simasdalang');
    }

}
