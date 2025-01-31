<?php

use App\Http\Controllers\AnswersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspectController;
use App\Http\Controllers\BiodataCorespondensController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyReportController;

//role admin
Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['role:Super Admin|Surveyor']], function () {

        //Master Data
        Route::as('master-data.')
        ->prefix('master-data')
        ->group(function () {

            //Biodata
            Route::controller(BiodataCorespondensController::class)
            ->as('biodata.')
            ->prefix('biodata')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::get('/fetch-data', 'datatables')->name('fetch-data');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/delete', 'destroy')->name('delete');
            });

            //Aspect
            Route::controller(AspectController::class)
            ->as('aspect.')
            ->prefix('aspect')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::get('/fetch-data', 'datatables')->name('fetch-data');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/delete', 'destroy')->name('delete');
            });

            //Categories
            Route::controller(CategoriesController::class)
            ->as('categories.')
            ->prefix('categories')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::get('/fetch-data', 'datatables')->name('fetch-data');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/delete', 'destroy')->name('delete');
            });

            //Answers
            Route::controller(AnswersController::class)
            ->as('answers.')
            ->prefix('answers')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::get('/fetch-data', 'datatables')->name('fetch-data');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/delete', 'destroy')->name('delete');
            });

            //Questions
            Route::controller(QuestionsController::class)
            ->as('questions.')
            ->prefix('questions')
            ->group(function () {
                Route::get('/', 'index')->name('list');
                Route::get('/fetch-data', 'datatables')->name('fetch-data');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/delete', 'destroy')->name('delete');
            });
        });

        //Survey
        Route::controller(SurveyController::class)
        ->as('survey.')
        ->prefix('survey')
        ->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete', 'destroy')->name('delete');

            //Surveyor
            Route::post('/send-approval-survey', 'sendSurveyForApproval');

            //View Result
            Route::get('/view-survey-results', 'viewSurveyResult')->name('survey.results');
            Route::get('/survey-results', 'getSurveyResults')->name('survey.results');

            //Result
            Route::post('/export-result', 'surveyResultRawExport')->name('survey.results');
        });

        //Report
        Route::controller(SurveyReportController::class)
        ->as('survey-report.')
        ->prefix('survey-report')
        ->group(function () {
            //Index
            Route::get('/list', 'list')->name('list');
            Route::get('/fetch-data', 'datatables')->name('datatables');

            //View Report
            Route::get('/view-survey-responden/{id}', 'viewSurveyResponden');

            //View Entity
            Route::get('/view-survey-entity/{id}', 'viewSurveyEntity');

            //View Entity
            Route::get('/view-survey-gap/{id}', 'viewSurveyGap');

            //Export
            Route::post('/export-result', 'surveyResultRawExport')->name('survey.results');
        });
    });
});


