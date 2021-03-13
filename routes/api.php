<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\UserPostsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);

    Route::get('{user:username}/blogs', [UserPostsController::class, 'index'])->name('user-blogs-api');
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs-api');
    Route::get('blogs/{id}', [BlogController::class, 'show']);

    Route::post('follow/{id}', [FollowController::class, 'store'])->name('follow-user');
    Route::get('follow-status/{user_id}/{follower_id}', [FollowController::class, 'show'])->name('show-follow-status');
});
