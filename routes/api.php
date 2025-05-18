<?php

// use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

