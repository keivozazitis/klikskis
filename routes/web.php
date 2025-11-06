<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;



// Mājas lapa
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'show'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth'])->group(function () {
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('admin.user.delete');
Route::middleware(['auth'])->group(function () {
    Route::post('/user/{id}/report', [UserController::class, 'report'])->name('user.report');
});
Route::middleware(['auth'])->group(function () {
    Route::delete('/admin/report/{id}/delete', [AdminController::class, 'deleteReport'])->name('admin.report.delete');
});
Route::get('/freakclick', [App\Http\Controllers\UserController::class, 'freakclick'])->name('users.freakclick');
Route::post('/users/{id}/like', [App\Http\Controllers\LikeController::class, 'likeUser'])
     ->middleware('auth')
     ->name('user.like');
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
});
