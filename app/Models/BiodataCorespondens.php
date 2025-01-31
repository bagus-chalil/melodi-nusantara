<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiodataCorespondens extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'biodata_corespondens';

    public static function getBiodataActive(){
        return self::where('status','1')->get();
    }
}
