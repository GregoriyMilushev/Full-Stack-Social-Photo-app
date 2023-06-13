<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => ['api'],
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', AuthController::class . '@login');
        Route::post('registration', AuthController::class . '@registration');
        Route::post('logout', AuthController::class . '@logout');
        Route::post('refresh', AuthController::class . '@refresh');
        Route::get('me', AuthController::class . '@me');
    });
});

Route::group([
    'middleware' => ['auth:api']
], function ($router) {
 
    Route::resource('photo', PhotoController::class);
    Route::resource('comment', CommentController::class);

    Route::resource('file-upload', FileUploadController::class);

});

Route::group([
    'middleware' => ['auth:api', 'auth.admin']
], function ($router) {
 
    // Route::resource('photo', PhotoController::class);
    // Route::resource('comment', CommentController::class);

    // Route::resource('file-upload', FileUploadController::class);

});

