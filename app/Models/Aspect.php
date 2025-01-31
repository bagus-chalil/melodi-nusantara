<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Aspect extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'aspects';

    public function categories(): HasMany
    {
        return $this->hasMany(Categories::class,'aspect_id','id');
    }

    public static function getAspectActive(){
        return self::where('status','1')->get();
    }

    public static function getSurveyQuestion(){
        return self::with([
            'categories' => function ($query) {
                $query->where('status', '1');
            },
            'categories.questions' => function ($query) {
                $query->where('status', '1');
            },
            'categories.questions.answers' => function ($query) {
                $query->where('status', '1');
            }
        ])->where('status', '1')->get();
    }

    public static function getAllAspectDataForReport()
    {
        return self::with([
            'categories' => function ($query) {
                $query->where('status', '1');
            },
            'categories.questions' => function ($query) {
                $query->where('status', '1');
            },
            'categories.questions.answers' => function ($query) {
                $query->where('status', '1');
            }
        ])->withCount([
            'categories' => function ($query) {
                $query->where('status', '1');
            }
        ])->where('status', '1')->get();
    }

}
