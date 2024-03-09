<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        $user = User::create($this->principalData($request->only('fullname', 'nickname', 'email', 'password')));

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user,
        ], 201);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $user->update($this->principalData($request->only('fullname', 'nickname', 'email', 'password')));

        return response()->json([
            'message' => 'Successfully updated user profile!',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('cms-api-project')->accessToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                ]
                , 200);
        } else {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
            'logout' => TRUE
        ]);
    }

    public function user(Request $request){
        return response()->json(Auth::user());
    }

    private function principalData(array $data): array
    {
        return [
            'fullname' => $data['fullname'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
    }
}
