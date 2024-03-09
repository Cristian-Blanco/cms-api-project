<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\RoleResource\RoleController;
use App\Http\Controllers\CRUD\ArticleResource\ArticleController;

Route::group(['prefix' => 'form', 'middleware' => ['auth:api', 'permissions.role']], function() {
    Route::match(['get', 'post', 'put', 'delete'],'/roles', RoleController::class)
        ->middleware('role.resource')->name('roles');
    Route::match(['get', 'post', 'put', 'delete'],'/articles', ArticleController::class)
        ->middleware('article.resource')->name('articles');
});
