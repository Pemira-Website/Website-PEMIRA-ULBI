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
    Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
?>