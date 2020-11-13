<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function getUserAuth(User $user)
    {
        $data = new UserResource($user->find(Auth::id()));

        return $this->SendResponse('success', 'Data loaded', [$data], 200);
    }

    public function update(Request $request)
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

        File::delete(public_path('image/products/') . $data->image);

        $image =  Auth::user()->username . '-' . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(public_path('image/users'), $image);

        $data->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'avatar' => $image,
        ]);

        return response([
            'status' => 'success',
            'message' => 'Profile berhasil diubah'
        ], 202);
    }
}
