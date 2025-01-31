<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DivisionWork extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'division_work';

    public static function getDivisionWorkActive(){
        return self::where('status','1')->get();
    }
}
