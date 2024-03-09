<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserController;

include __DIR__.'/form.php';

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [UserController::class, 'login'])->middleware('login');
    Route::post('signup', [UserController::class, 'signUp'])->middleware('signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('user', [UserController::class, 'user']);
        Route::post('update-profile', [UserController::class, 'updateProfile'])->middleware('update.profile');
    });
});