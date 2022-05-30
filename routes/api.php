<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$ver = config('app.api_version');

Route::group(['prefix' => $ver, 'as' => $ver . '_newsletters::'], function () {
    Route::get('newsletters', [
        App\Http\Controllers\NewslettersController::class,
        'getNewsletters',
        'as' => 'list',
    ]);
    Route::get('newsletters/{filename}', [
        App\Http\Controllers\NewslettersController::class,
        'getNewsletter',
        'as' => 'detail',
    ]);
});

Route::group(['prefix' => $ver, 'as' => $ver . '_adoption-applications::'], function () {
    Route::get('adoption-applications', [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'getApplications',
        'as' => 'adoption-applications',
    ])->middleware('bas.auth');

    Route::post('adoption-applications', [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'store',
        'as' => 'adoption-applications',
    ])->middleware('bas.auth')->middleware('bas.new.adoption.application');

    Route::get('adoption-applications/{token}', [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'getApplication',
        'as' => 'adoption-applications/{token}',
    ])->middleware('bas.auth')->middleware('bas.get.adoption.application');

    Route::patch('adoption-applications/{token}', [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'saveApplicationField',
        'as' => 'adoption-applications/{token}',
    ])->middleware('bas.auth')->middleware('bas.get.adoption.application');

    Route::post('adoption-applications/{token}', [
        App\Http\Controllers\AdoptionApplicationsController::class,
        'setApplicationStatus',
        'as' => 'adoption-applications/{token}',
    ])->middleware('bas.auth')->middleware('bas.get.adoption.application');
});

Route::group(['prefix' => $ver, 'as' => $ver . '_authenticate::'], function () {
    Route::get('authenticate', [
        App\Http\Controllers\Auth\AuthenticationController::class,
        'authenticate',
        'as' => 'authenticate',
    ])->middleware('bas.auth');

    Route::post('authenticate/get-started', [
        App\Http\Controllers\Auth\AuthenticationController::class,
        'getStarted',
        'as' => 'authenticate/get-started',
    ])->middleware('bas.recaptcha');

    Route::post('authenticate/login', [
        App\Http\Controllers\Auth\AuthenticationController::class,
        'authenticate',
        'as' => 'authenticate/login',
    ])->middleware('bas.login');
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
