<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Songs extends Model {
    use HasFactory;
    protected $fillable = ['title', 'description', 'file_path', 'lyrics', 'thumbnail', 'region', 'category', 'source'];

    public function getFileUrlAttribute() {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getLyricsUrlAttribute() {
        return $this->lyrics ? asset('storage/' . $this->lyrics) : null;
    }

    public function getThumbnailUrlAttribute() {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('default-thumbnail.jpg');
    }
}


