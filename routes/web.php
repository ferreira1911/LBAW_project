<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Broadcast;

// Home
Route::view('/', 'welcome')->name('home');
Route::view('/faq', 'pages.faq')->name('faq');


// Blocked Account Page
Route::view('/account/blocked', 'auth.blocked')->name('account.blocked');

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
Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');


// Auctions
Route::controller(AuctionController::class)->group(function () {
    Route::get('/auctions', 'index')->name('auctions.index');
    Route::get('/auctions/create', 'create')->name('auctions.create');
    Route::post('/auctions', 'store')->name('auctions.store');
    Route::get('/auctions/search', 'search')->name('auctions.search');
    Route::get('/auctions/admin','administration')->name('auctions.admin');
    
    Route::get('/auctions/{auction}', 'show')->whereNumber('auction')->name('auctions.show');
    Route::get('/auctions/{auction}/edit', 'edit')->whereNumber('auction')->name('auctions.edit');
    Route::put('/auctions/{auction}', 'update')->whereNumber('auction')->name('auctions.update');
    Route::post('/auction/{auction}/follow',  'toggleFollow')->name('auction.follow');
    Route::post('/auctions/{auction}/cancel', 'cancel')->name('auctions.cancel');
    Route::delete('/auctions/{auction}/images/{image}', 'destroyImage')->whereNumber('auction')->name('auctions.images.destroy');
    Route::post('/auctions/{auction}/buy-now', 'buyNow')->name('auctions.buyNow')->middleware('auth');
    Route::post('/auctions/{auction}/feature', 'feature')->name('auctions.feature');
});

// Bids
Route::controller(BidController::class)->middleware('auth')->group(function () {
    Route::post('/auctions/{auction}/bids', 'store')->name('bids.store')->middleware('auth');
    Route::get('/bidding-history', 'index')->name('bidding-history.index')->middleware('auth');
});

// Users
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/api', 'getUsers')->name('users.api');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}', 'show')->name('users.show');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::post('/users/{user}', 'update')->name('users.update');
    Route::post('/users/{user}/delete', 'destroy')->name('users.destroy');

    Route::post('/users/{user}/block', 'block')->name('users.block');
    Route::post('/users/{user}/unblock', 'unblock')->name('users.unblock');
});

// Wallet / Transactions
Route::controller(TransactionController::class)->middleware('auth')->group(function () {
    Route::get('/wallet', 'index')->name('transactions.index');
    Route::post('/wallet/filter','filter')->name('transactions.filter');
    
    Route::get('/wallet/add-credit', 'createCredit')->name('credit.create');
    Route::post('/wallet/add-credit', 'storeCredit')->name('credit.store');

    Route::get('/wallet/add-credit/success', 'successCredit')->name('credit.success');
    Route::get('/wallet/add-credit/cancel', 'cancelCredit')->name('credit.cancel');
    
    Route::get('/wallet/withdraw', 'createWithdrawal')->name('withdrawal.create');
    Route::post('/wallet/withdraw', 'storeWithdrawal')->name('withdrawal.store');
    
    Route::get('/wallet/{transaction}', 'show')->name('transaction.show');
});

// Notifications
Route::controller(NotificationController::class)->middleware('auth')->group(function(){
    Route::get('/notifications','index')->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', 'markAsRead')->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', 'markAllRead')->name('notifications.markAllRead');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Handle the form submission (Sending the email)
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'reset')->name('password.update');
});

Route::controller(CategoryController::class)->middleware('auth')->group(function () {
    Route::get('/categories/create', 'create')->name('categories.create');
    Route::post('/categories/store', 'store')->name('categories.store');
});

Route::controller(ReportController::class)->middleware('auth')->group(function () {
    
    Route::get('/report/create', 'create')->name('report.create');
    Route::get('/reports/myReports', 'indexAssigned')->name('admin.myReports');
    Route::post('/report', 'store')->name('report.store');
    Route::get('/reports', 'index')->name('reports.admin');
    Route::get('/reports/{report}', 'show')->name('reports.show');
    Route::post('/reports/{report}/assign', 'assign')->name('report.assign');
    Route::post('/reports/{report}/dismiss', 'dismiss')->name('report.dismiss');
    Route::post('/reports/{report}/resolve', 'resolve')->name('report.resolve');
});

// About Us
Route::view('/about', 'pages.about')->name('about');


//Contact Form
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::view('/contact', 'pages.contact')->name('contact');



Route::controller(MessageController::class)->middleware('auth')->group(function () {
    // Chat Window: View conversation with a specific user
    Route::get('/messages/{user}', 'show')->name('messages.show');
    
    // Send Message (AJAX/CSR): Returns JSON
    Route::post('/messages', 'store')->name('messages.store');
    
    // Delete Message
    Route::delete('/messages/{message}', 'destroy')->name('messages.destroy');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google-call-back');
});


// Profile AJAX tab routes
Route::get('/users/{user}/auctions', [UserController::class, 'loadAuctions'])->name('users.load.auctions');
Route::get('/users/{user}/watchlist', [UserController::class, 'loadWatchlist'])->name('users.load.watchlist');
Route::get('/users/{user}/won', [UserController::class, 'loadWon'])->name('users.load.won');
Route::get('/users/{user}/messages', [UserController::class, 'loadMessages'])->name('users.load.messages');

// Reviews
Route::controller(ReviewController::class)->middleware('auth')->group(function () {
    Route::get('/auctions/{auction}/review', 'create')->name('reviews.create');
    Route::post('/auctions/{auction}/review', 'store')->name('reviews.store');
});
