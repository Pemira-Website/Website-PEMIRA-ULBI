<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuVoteController;
use App\Http\Controllers\PaslonController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
Route::get('/vote.paslon', [PaslonController::class, 'paslon']);
Route::get('/vote.paslon_himatif',[PaslonController::class, 'himatif'])->name('paslon_himatif');
Route::get('/vote.paslon_himagis',[PaslonController::class, 'himagis'])->name('paslon_himagis');
Route::get('/vote.paslon_himalogbis',[PaslonController::class, 'himalogbis'])->name('paslon_himalogbis');
Route::get('/vote.paslon_hma',[PaslonController::class, 'hma'])->name('paslon_hma');
Route::get('/vote.paslon_himaporta',[PaslonController::class, 'himaporta'])->name('paslon_himaporta');
Route::get('/vote.paslon_himasta',[PaslonController::class, 'himasta'])->name('paslon_himasta');
Route::get('/vote.paslon_himabig',[PaslonController::class, 'himabig'])->name('paslon_himabig');
Route::get('/vote.paslon_himanbis',[PaslonController::class, 'himanbis'])->name('paslon_himanbis');
Route::get('/vote.paslon_hicomlog',[PaslonController::class, 'hicomlog'])->name('paslon_hicomlog');
Route::get('/vote.paslon_himamera',[PaslonController::class, 'himamera'])->name('paslon_himamera');
?>