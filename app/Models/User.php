<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetKataSandi;
use App\Notifications\VerifikasiEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

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
        $this->notify(new ResetKataSandi($resetUrl));
    }

    public function sendEmailVerificationNotification()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        // Kirim notifikasi dengan URL verifikasi yang benar
        $this->notify(new VerifikasiEmail($verificationUrl));
    }

    // Relasi ke model SuratMasuk
    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class);
    }
}
