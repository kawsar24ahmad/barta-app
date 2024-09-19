<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware'=> 'guest'],function () {
    Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'], '/', [AuthController::class, 'login'])->name('login');
    
});

Route::group(['middleware'=> 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::match(['get', 'put'], '/edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
