<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Questions extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'questions';

    public function categories(): HasOne
    {
        return $this->hasOne(Categories::class,'id','categories_id');
    }

    public function answers(): HasOne
    {
        return $this->hasOne(Answers::class,'id','answer_id');
    }

    public static function getAllQuestions(){
        return self::with('categories.aspects','answers')->get();
    }
}
