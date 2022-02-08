<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

trait Athorized
{
    private function authorized()
    {
        try {
            return auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            response()->json([
                'message' => 'not autorized',
            ], 401)->send();
            exit;
        }
    }

    private function getOwnerShip($forum_id)
    {
        $user = $this->authorized();
        if ($user->id != $forum_id) {
            response()->json([
                'message' => 'UnAuthorized',
            ], 401)->send();
            exit;
        }

    }
}