<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'place_birth',
        'date_birth',
        'address',
        'phone_number',
        'school',
        'major',
        'internship_start',
        'internship_end',
        'photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_birth' => 'date',
        'internship_start' => 'date',
        'internship_end' => 'date',
    ];

    public function activities()
    {
        // return $this->hasMany(Activity::class,'user_id');
        return $this->hasMany(Activity::class);
    }

    public function sendPasswordResetNotification($token)
    {
        // Generate URL reset password dengan menyertakan token dan email
        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $this->email, // Menggunakan email user yang sedang login
        ]);

        // Kirim notifikasi reset password ke email user
        $this->notify(new class($token, $resetUrl) extends ResetPasswordNotification {
            protected $resetUrl;

            public function __construct($token, $resetUrl)
            {
                parent::__construct($token);
                $this->resetUrl = $resetUrl;
            }

            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Reset Password Notification')
                    ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
                    ->action('Reset Password', $this->resetUrl)
                    ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
            }
        });
    }
}
