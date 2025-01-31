<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model {
    use HasFactory;
    protected $fillable = ['name', 'cover_image'];

    // Mendapatkan URL lengkap gambar cover
    public function getCoverUrlAttribute() {
        return asset('storage/' . $this->cover_image);
    }
}


