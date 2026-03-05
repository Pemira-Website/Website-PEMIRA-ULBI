<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuVoteController;
use App\Http\Controllers\PaslonController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\EnsurePemilihIsAuthenticated;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Hasil vote bisa dilihat publik
Route::get('/hasilvote', function () {
    $jenis_pemilihans = \App\Models\Paslon::select('jenis_pemilihan')->distinct()->pluck('jenis_pemilihan');
    return view('hasilvote', compact('jenis_pemilihans'));
})->name('hasilvote');

// Protected routes - hanya pemilih yang sudah login
Route::middleware([EnsurePemilihIsAuthenticated::class])->group(function () {
    Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
    Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
    Route::post('/vote/{npm}', [VoteController::class, 'addVote'])->name('vote.add');
});