<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Categories extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'categories';

    public function aspects(): HasOne
    {
        return $this->hasOne(Aspect::class,'id','aspect_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class,'categories_id','id');
    }

    public static function getCategoriesActive(){
        return self::with('aspects')->where('status','1')->get();
    }
}
