<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['no_surat', 'tanggal', 'asal_pengirim', 'file_pdf', 'balasan_pdf', 'user_id'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
