<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function ($router) {

    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('register', 'RegisterController@register');
    });
    Route::get('users/@{username}', 'UserController@show');
    Route::get('forums/tag/{category}', 'ForumController@filter');
    Route::get('myForums', 'ForumController@getUserForum');
    Route::get('myForums/{id}', 'ForumController@getForumById');
    Route::post('myForums/{id}', 'ForumController@updateData');
    Route::post('updateForums', 'ForumController@updateValue');
    Route::apiResource('forums', 'ForumController');
    Route::apiResource('forums.comments', 'ForumCommentController');
});