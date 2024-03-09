<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\RoleResource\RoleController;

Route::group(['prefix' => 'form', 'middleware' => ['auth:api', 'permissions.role']], function() {
    Route::match(['get', 'post', 'put', 'delete'],'/roles', RoleController::class)->middleware('role.resource');
});
