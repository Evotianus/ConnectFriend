<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FriendController::class, 'index']);

Route::get('/locale/{locale}', [UserController::class, 'language'])->name('locale.switch');

// 👉 User Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate']);

    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/profile', [UserController::class, 'show']);

    Route::get('/notifications', [UserController::class, 'notifications']);
    Route::delete('/notifications/{id}', [UserController::class, 'markAsRead']);

    Route::post('/friend/{user}', [FriendController::class, 'store']);
    Route::delete('/friend/{user}', [FriendController::class, 'destroy']);

    Route::get('/chat/{user}', [FriendController::class, 'chat']);
    Route::post('/chat/{user}', [FriendController::class, 'send']);

    Route::get('/payment', [UserController::class, 'paymentForm']);
    Route::post('/payment', [UserController::class, 'payment']);
});
