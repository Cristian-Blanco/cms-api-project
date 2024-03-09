<?php

namespace App\Http\Middleware\CRUD\ArticleResource\Filters;

use Illuminate\Http\Request;
use App\Http\Middleware\CRUD\Interfaces\ValidateData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeleteMiddleware implements ValidateData
{
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => [
                'required_without:article_ids',
                'integer',
                'exists:articles,id',
            ],
            'article_ids' => [
                'required_without:article_id',
                'array',
            ],
            'article_ids.*' => 'integer|exists:articles,id',
        ]);

        if ($validator->fails()){
            return ['error' => TRUE, 'message' => $validator->errors()];
        }

        return ['error' => FALSE];
    }
}