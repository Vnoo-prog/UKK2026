<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasis';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'lokasi',
        'keluhan',
        'gambar',
        'status',
        'feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Category::class);
    }
}