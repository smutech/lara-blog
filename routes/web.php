<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/create', [BlogController::class, 'create'])->name('create-blog');
Route::post('/blogs', [BlogController::class, 'store'])->name('store-blog');
Route::get('/blog/{blog:slug}/edit', [BlogController::class, 'edit'])->name('edit-blog');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('show-blog');
Route::put('/blog/{blog:slug}', [BlogController::class, 'update'])->name('update-blog');
Route::delete('/blog/{blog:slug}', [BlogController::class, 'destroy'])->name('delete-blog');

// Profile
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->middleware('auth')->name('edit-profile');
Route::post('/profile/edit', [UserProfileController::class, 'update'])->middleware('auth');
Route::get('/profile/{username?}', [UserProfileController::class, 'index'])->name('profile');
