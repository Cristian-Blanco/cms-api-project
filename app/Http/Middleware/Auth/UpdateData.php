<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:3|max:50|regex:/^[\p{L}\s]+$/u',
            'nickname' => 'required|string|min:3|max:30|regex:/^[\p{L}\s]+$/u',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return $next($request);
    }
}
