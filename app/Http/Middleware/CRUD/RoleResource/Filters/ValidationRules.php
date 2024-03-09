<?php

namespace App\Http\Middleware\CRUD\RoleResource\Filters;

class ValidationRules
{
    public static function getRules($additionalRules = []) : array
    {
        $regex = "/^[\p{L}\s]+$/u";

        $rules = [
            // Role
            'name' => 'required|string|min:3|max:50|regex:'.$regex,
            'description' => 'required|string|min:3|max:300|regex:'.$regex,
            'tag' => 'required|string|min:3|max:25|regex:'.$regex,

            // Permissions
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],

            // Forms
            'forms' => ['array'],
            'forms.*' => ['exists:forms,id'],

            // Users
            'users' => ['required', 'array'],
            'users.*' => ['exists:users,id'],
        ];

        if (!empty($additionalRules)) {
            $rules = array_merge($rules, $additionalRules);
        }

        return $rules;
    }
}