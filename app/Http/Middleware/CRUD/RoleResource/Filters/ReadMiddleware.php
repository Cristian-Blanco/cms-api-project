<?php

namespace App\Http\Middleware\CRUD\RoleResource\Filters;

use Illuminate\Http\Request;
use App\Http\Middleware\CRUD\Interfaces\ValidateData;
use Illuminate\Support\Facades\Validator;

class ReadMiddleware implements ValidateData
{
    public function validate(Request $request)
    {
        return ['error' => FALSE];
    }
}