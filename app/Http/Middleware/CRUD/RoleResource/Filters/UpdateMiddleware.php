<?php

namespace App\Http\Middleware\CRUD\RoleResource\Filters;

use Illuminate\Http\Request;
use App\Http\Middleware\CRUD\Interfaces\ValidateData;
use Illuminate\Support\Facades\Validator;

class UpdateMiddleware implements ValidateData
{
    public function validate(Request $request)
    {
        $additionalRules = [
            'role_id' => 'required|integer|exists:roles,id',
        ];

        $validator = Validator::make($request->all(), ValidationRules::getRules($additionalRules));

        if ($validator->fails()){
            return ['error' => TRUE, 'message' => $validator->errors()];
        }

        return ['error' => FALSE];
    }
}
