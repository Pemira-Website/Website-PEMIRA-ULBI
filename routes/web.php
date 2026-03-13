<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuVoteController;
use App\Http\Controllers\PaslonController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\EnsurePemilihIsAuthenticated;
use App\Models\Paslon;
use App\Support\PemiraConfig;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Hasil vote bisa dilihat publik
Route::get('/hasilvote', function () {
    $showPublicResults = PemiraConfig::canShowPublicResults();
    $jenisPemilihans = collect();

    if ($showPublicResults) {
        $availableTypes = Paslon::query()
            ->select('jenis_pemilihan')
            ->distinct()
            ->pluck('jenis_pemilihan')
            ->toArray();

        $orderedTypes = array_values(array_intersect(
            array_keys(PemiraConfig::voteTypes()),
            $availableTypes
        ));

        $jenisPemilihans = collect($orderedTypes);
    }

    return view('hasilvote', [
        'jenis_pemilihans' => $jenisPemilihans,
        'show_public_results' => $showPublicResults,
        'results_notice' => PemiraConfig::publicResultNotice(),
        'result_visibility_mode' => PemiraConfig::resultVisibilityMode(),
    ]);
})->name('hasilvote');

// Protected routes - hanya pemilih yang sudah login
Route::middleware([EnsurePemilihIsAuthenticated::class])->group(function () {
    Route::get('/menuvote/{prodi}', [MenuVoteController::class, 'show'])->name('menuvote');
    Route::get('/vote/{jenis_pemilihan}', [PaslonController::class, 'index'])->name('vote.show');
    Route::post('/vote', [VoteController::class, 'addVote'])->name('vote.add');
});
