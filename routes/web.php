<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login_register', function () {
    return view('login_register'); // NEVIS 'login'
});
Route::post('/login', function () {
    return 'Login submitted!';
})->name('login');

Route::post('/register', function () {
    return 'Register submitted!';
})->name('register');