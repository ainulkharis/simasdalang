<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetKataSandi extends Notification
{
    public $resetUrl;

    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Atur Ulang Password')
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan pengaturan ulang password akun Anda.')
            ->action('Atur Ulang Password', $this->resetUrl)
            ->line('Jika Anda tidak meminta pengaturan ulang password, abaikan email ini.')
            ->salutation('Salam, Tim Simasdalang');
    }
}
