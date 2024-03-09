<?php

namespace App\Http\Middleware\CRUD\RoleResource\Filters;

use Illuminate\Http\Request;
use App\Http\Middleware\CRUD\Interfaces\ValidateData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeleteMiddleware implements ValidateData
{
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => [
                'required_without:role_ids',
                'integer',
                'exists:roles,id',
                Rule::notIn([1]),
            ],
            'role_ids' => [
                'required_without:role_id',
                'array',
                function ($attribute, $value, $fail) {
                    if (in_array(1, $value)) {
                        $fail('The role_ids array cannot contain index 1.');
                    }
                },
            ],
            'role_ids.*' => 'integer|exists:roles,id',
        ]);

        if ($validator->fails()){
            return ['error' => TRUE, 'message' => $validator->errors()];
        }

        return ['error' => FALSE];
    }
}