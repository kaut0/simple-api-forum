<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function show($username)
    {
        return new UserResource(
            User::where('username', $username)->first());
    }
}