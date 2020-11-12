<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'status' => 'success',
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'require|unique:users',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6'
        ]);

        $data = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response([
            'status' => 'success',
            'data' => $data,
        ], 201);
    }

    public function logout()
    {
        JWTAuth::invalidate(Auth::id());

        return response([
            'status' => 'success',
            'message' => 'token berhasil dihapus'
        ], 200);
    }
}
