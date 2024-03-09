<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class SignUp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:3|max:50|regex:/^[\p{L}\s]+$/u',
            'nickname' => 'required|string|min:3|max:30|regex:/^[\p{L}\s]+$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        
        return $next($request);
    }
}
