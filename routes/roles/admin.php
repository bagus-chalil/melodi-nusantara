<?php

use App\Http\Controllers\AnswersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspectController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SurveyController;

//role admin
Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['role:Super Admin|Admin']], function () {

        //Survey
        Route::controller(SurveyController::class)
        ->as('survey.')
        ->prefix('survey')
        ->group(function () {
            //Admin
            Route::get('/approval', 'approval');
            Route::post('/approve-form-survey', 'approveFormSurvey');
        });
    });
});


