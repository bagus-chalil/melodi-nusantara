<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Songs extends Model {
    use HasFactory;
    protected $fillable = ['title', 'artist', 'genre_id', 'description', 'lyrics', 'region', 'file_path'];

    public function genre() {
        return $this->belongsTo(Genres::class);
    }

    // Mendapatkan URL lengkap file musik
    public function getFileUrlAttribute() {
        return asset('storage/' . $this->file_path);
    }
}


