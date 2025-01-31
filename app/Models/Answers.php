<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Answers extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'answers';

    public static function getAnswersActive(){
        return self::where('status','1')->get();
    }
}
