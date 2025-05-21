<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'photo',
        'user_id',
        'nilai',
        'sudah_dinilai',
    ];

    protected $casts = [
        'date' => 'date',
        'nilai' => 'integer',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->date->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
