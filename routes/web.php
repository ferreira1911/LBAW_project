<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;

// Home
Route::redirect('/', '/login');


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout')->name('logout');
});


Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::post('/send', [MailController::class, 'send']);

Route::post('/post/like', [PostController::class, 'like']);

Route::controller(AuctionController::class)->group(function () {
    Route::get('/auction', 'index')->name('auctions.index');
    Route::get('/auction/{auction}', 'show')->name('auction.show');
    Route::post('/auction/store', 'store')->name('auction.store');
    Route::post('/auction/create', 'create')->name('auction.create');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('users.index');
    Route::get('/user/{user}', 'show')->name('user.show');
    Route::post('/user/store', 'store')->name('user.store');
    Route::get('/user/{user}/edit', 'edit')->name('user.edit');
    Route::post('/user/{user}', 'update')->name('user.update');
    Route::post('/user/{user}/destroy', 'destroy')->name('user.destroy');
});

Route::post('/file/upload', [FileController::class, 'upload']);