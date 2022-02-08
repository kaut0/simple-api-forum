<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'username' => 'required|string|between:2,100|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => Hash::make(request('password'))]
        ));

        return response()->json([
            'message' => 'Berhasil Membuat Akun',
            'user' => $user,
        ], 201);
    }
}