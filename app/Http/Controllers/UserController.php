<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show($username)
    {
        return User::where('username', $username)->select('username', 'created_at')->first();
    }
}