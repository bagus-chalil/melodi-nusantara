<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Survey extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'surveys';

    public function aspects(): HasOne
    {
        return $this->hasOne(Aspect::class,'id','aspect_id');
    }

}
