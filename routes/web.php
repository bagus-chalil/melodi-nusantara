<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RouteController::class, 'redirect'])->name('redirect');

Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(SurveyController::class)
        ->as('survey.')
        ->prefix('survey')
        ->group(function () {
            Route::get('/', 'index')->name('list');
            Route::get('/fetch-data', 'datatables')->name('fetch-data');

            //Survey Admin
            Route::as('.survey-admin.')
            ->prefix('/survey-admin')
            ->group(function () {
                Route::get('/intro/{id}','introSurveyAdmin');
                Route::post('/form/{id}','detailFormSurvey');
                Route::post('/submit','surveyAdminSubmit');
            });

    });
});
Route::controller(SurveyController::class)
    ->as('survey.')
    ->prefix('survey')
    ->group(function () {
        //Survey Admin
        Route::as('.survey-guest.')
        ->prefix('survey-guest')
        ->group(function () {
            Route::get('/intro/{token}','introSurveyGuest');
            Route::get('/close','CloseSurvey');
            Route::post('/form/{id}','detailFormSurvey');
            Route::post('/submit','surveyGuestSubmit');
        });

});



require __DIR__.'/auth.php';
require __DIR__.'/roles/surveyor.php';
require __DIR__.'/roles/admin.php';

