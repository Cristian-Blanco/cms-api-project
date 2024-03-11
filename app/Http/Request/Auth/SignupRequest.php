<?php

namespace App\Http\Request\Auth;

// use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => 'required|string|min:3|max:50|regex:/^[\p{L}\s]+$/u',
            'nickname' => 'required|string|min:3|max:30|regex:/^[\p{L}\s]+$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ];
    }
}