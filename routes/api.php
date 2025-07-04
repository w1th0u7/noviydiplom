<?php


use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;

Route::post('/api-register', [UserController::class, 'register'])->name('api.register');

Route::post('/login', [UserController::class, 'login'])->name('login.api');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout.api');
});

