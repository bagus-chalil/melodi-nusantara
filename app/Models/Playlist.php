<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'song_id'];

    /**
     * Relasi ke User (Pemilik Playlist)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Songs (Banyak Lagu)
     */
    public function songs()
    {
        return $this->belongsToMany(Songs::class, 'song_id');
    }
}
