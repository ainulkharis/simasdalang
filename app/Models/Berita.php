<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate slug secara otomatis dari judul
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });

        static::updating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }

    // Menggunakan slug sebagai parameter route
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
