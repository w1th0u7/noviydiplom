<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::middleware('auth:api')->group(function () {
    Route::get('/admin/adminpanel', [AdminController::class, 'index'])->name('admin.adminpanel');
    Route::post('/admin/tours/create', [AdminController::class, 'createTour'])->name('admin.tours.create');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

