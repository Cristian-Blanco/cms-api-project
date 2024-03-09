<?php

namespace App\Http\Middleware\CRUD\ArticleResource\Filters;

use Illuminate\Http\Request;
use App\Http\Middleware\CRUD\Interfaces\ValidateData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateMiddleware implements ValidateData
{
    public function validate(Request $request)
    {
        $additionalRules = [
            'article_id' => [
                'required',
                'integer',
                'exists:articles,id',
            ],
        ];

        $validator = Validator::make($request->all(), ValidationRules::getRules($additionalRules));

        if ($validator->fails()){
            return ['error' => TRUE, 'message' => $validator->errors()];
        }

        return ['error' => FALSE];
    }
}
