<?php

namespace App\Http\Middleware\CRUD\ArticleResource\Filters;

class ValidationRules
{
    public static function getRules($additionalRules = []) : array
    {
        $regex = "/^[\p{L}\s]+$/u";

        $rules = [
            // Role
            'title' => 'required|string|min:3|max:50|regex:'.$regex,
            'description' => 'required|string|min:3|max:300|regex:'.$regex,

            'image' => 'file|mimes:jpeg,png,gif',
            'video' => 'file|mimes:mp4,mov,avi',
            'status' => 'boolean',
        ];

        if (!empty($additionalRules)) {
            $rules = array_merge($rules, $additionalRules);
        }

        return $rules;
    }
}