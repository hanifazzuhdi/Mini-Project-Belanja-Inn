<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response([
            'status' => 'Success',
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6',
            // 'avatar' => 'image|file'
        ]);

        // $image = 'User-' . time() . Str::random(3) . $request->avatar->getClientOriginalExtension();
        // $request->avatar->move(public_path('image', $image));

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'avatar' => $image
        ]);

        $token = JWTAuth::fromUser($data);

        return response([
            'status' => 'Success',
            'data' => $data,
            'token' => $token
        ], 201);
    }
}
