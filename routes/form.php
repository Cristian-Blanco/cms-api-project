<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\RoleResource\RoleController;

Route::group(['middleware' => ['auth:api']], function() {
    Route::match(['get', 'post', 'put', 'delete'],'/role-resource', RoleController::class)->middleware('role.resource');
});
