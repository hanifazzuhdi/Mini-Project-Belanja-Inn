<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserAuth(User $user)
    {
        $data = $user->find(Auth::id());

        return response([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $data = User::find(Auth::id());

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'avatar' => 'required'
        ]);
    }
}
