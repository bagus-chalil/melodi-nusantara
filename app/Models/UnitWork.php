<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitWork extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'unit_work';

    public static function getUnitWorkActive(){
        return self::where('status','1')->get();
    }
}
