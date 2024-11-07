<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', function () {
    return view('welcome'); // Pastikan Anda membuat file welcome.blade.php
})->name('home');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/menu_vote', [AuthController::class, 'menuvote']);
Route::get('/paslon', [AuthController::class, 'paslon']);
?>