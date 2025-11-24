<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BidController;

// Home
Route::view('/', 'welcome')->name('home');

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

// Utilities
Route::post('/send', [MailController::class, 'send']);
Route::post('/post/like', [PostController::class, 'like']);
Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');


// Auctions
Route::controller(AuctionController::class)->group(function () {
    Route::get('/auctions', 'index')->name('auctions.index');
    Route::get('/auctions/create', 'create')->name('auctions.create');
    Route::post('/auctions', 'store')->name('auctions.store');
    Route::get('/auctions/search', 'search')->name('auctions.search');
    
    Route::get('/auctions/{auction}', 'show')->whereNumber('auction')->name('auctions.show');
    Route::get('/auctions/{auction}/edit', 'edit')->whereNumber('auction')->name('auctions.edit');
    Route::put('/auctions/{auction}', 'update')->whereNumber('auction')->name('auctions.update');
    
    Route::post('/auctions/{auction}/cancel', 'cancel')->name('auctions.cancel');
    Route::delete('/auctions/{auction}/images/{image}', 'destroyImage')->whereNumber('auction')->name('auctions.images.destroy');
});

// Bids
Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])->name('bids.store')->middleware('auth');

// Users
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/api', 'getUsers')->name('users.api');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    
    Route::get('/users/{user}', 'show')->name('users.show');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::post('/users/{user}', 'update')->name('users.update');
    Route::get('/users/{user}/destroy', 'destroy')->name('users.destroy');
});

// Wallet / Transactions
Route::controller(TransactionController::class)->middleware('auth')->group(function () {
    Route::get('/wallet', 'index')->name('transactions.index');
    
    Route::get('/wallet/add-credit', 'createCredit')->name('credit.create');
    Route::post('/wallet/add-credit', 'storeCredit')->name('credit.store');
    
    Route::get('/wallet/withdraw', 'createWithdrawal')->name('withdrawal.create');
    Route::post('/wallet/withdraw', 'storeWithdrawal')->name('withdrawal.store');
    
    Route::get('/wallet/{transaction}', 'show')->name('transaction.show');
});

// Notifications
Route::controller(NotificationController::class)->group(function(){
    Route::get('/notifications','index')->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', 'markAsRead')->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', 'markAllRead')->name('notifications.markAllRead');
});