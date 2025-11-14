<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BidController;

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
    Route::get('/auction/create', 'create')->name('auction.create');
    Route::post('/auction/store', 'store')->name('auction.store');
    Route::get('/auction/search', [AuctionController::class, 'search'])->name('auctions.search');
    Route::get('/auction/{auction}', 'show')->whereNumber('auction')->name('auction.show');
    Route::get('/auction/{auction}/edit', 'edit')->whereNumber('auction')->name('auction.edit');
    Route::put('/auction/{auction}', 'update')->whereNumber('auction')->name('auction.update');
    Route::post('/auction/{auction}/cancel', 'cancel')->name('auction.cancel');
});

Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])->name('bids.store')->middleware('auth');

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('users.index');
    Route::get('/user/{user}', 'show')->name('user.show');
    Route::post('/user/store', 'store')->name('user.store');
    Route::get('/user/{user}/edit', 'edit')->name('user.edit');
    Route::post('/user/{user}', 'update')->name('user.update');
    Route::post('/user/{user}/destroy', 'destroy')->name('user.destroy');
});

Route::post('/file/upload', [FileController::class, 'upload']);


Route::controller(TransactionController::class)->middleware('auth')->group(function () {
    // Histórico de transações (extrato)
    Route::get('/wallet', 'index')->name('transactions.index');

    // Adicionar Crédito
    Route::get('/wallet/add-credit', 'createCredit')->name('credit.create');
    Route::post('/wallet/add-credit', 'storeCredit')->name('credit.store');
    
    // Levantar Crédito
    Route::get('/wallet/withdraw', 'createWithdrawal')->name('withdrawal.create');
    Route::post('/wallet/withdraw', 'storeWithdrawal')->name('withdrawal.store');
    
    // Ver uma transação específica
    Route::get('/wallet/{transaction}', 'show')->name('transaction.show');
});