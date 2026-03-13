<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoteRequest;
use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoteController extends Controller
{
    /**
     * Tambahkan vote pada akun tertentu.
     *
     * @param  \App\Http\Requests\StoreVoteRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote(StoreVoteRequest $request)
    {
        $pemilih = $request->pemilih();
        
        if (!$pemilih) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Akun pemilih tidak ditemukan. Silakan login ulang.');
        }

        $paslon = $request->paslon();
        
        if (!$paslon) {
            return redirect()->back()->with('error', 'Paslon tidak ditemukan.');
        }

        $jenisPemilihanRaw = $pemilih->jenis_pemilihan;
        $user = Session::get('prodi');
        $jenisVote = (string) $request->validated('jenis_vote');

        // Parse jenis_pemilihan (format: "presma,himatif" atau single value)
        $allowedVotes = array_map('trim', explode(',', $jenisPemilihanRaw));
        
        // Check if this vote type is allowed for this pemilih
        $himaType = null;
        foreach ($allowedVotes as $vote) {
            if ($vote !== 'presma') {
                $himaType = $vote;
                break;
            }
        }

        // --- Custom Request Rate Limiting (Throttle) ---
        // Batasi klik tombol vote max 1 kali per 3 detik untuk NPM ini agar tidak men-spam queue/server
        $throttleKey = 'vote_throttle_'.$pemilih->npm;
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 1)) {
            return redirect()->back()->with('error', 'Terlalu banyak permintaan! Harap tunggu beberapa detik.');
        }
        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 3);
        // -----------------------------------------------

        $willBeFinished = false;
        $errorMessage = null;

        DB::transaction(function () use ($pemilih, $jenisVote, $himaType, &$willBeFinished, &$errorMessage): void {
            $lockedPemilih = Pemilih::where('id', $pemilih->id)->lockForUpdate()->first();

            if (!$lockedPemilih) {
                $errorMessage = 'Akun pemilih tidak ditemukan.';
                return;
            }

            $presmaStatus = $lockedPemilih->presma_status ?: Pemilih::defaultVoteStatus();
            $himaStatus = $lockedPemilih->hima_status ?: Pemilih::defaultVoteStatus();
            $isSpecial = PemiraConfig::isSpecialHima($himaType);

            if ($isSpecial) {
                if ($jenisVote !== 'presma') {
                    $errorMessage = 'Anda hanya dapat memilih Presma.';
                    return;
                }

                if (Pemilih::isLockedVoteStatus($presmaStatus)) {
                    $errorMessage = $presmaStatus === Pemilih::STATUS_PENDING
                        ? 'Vote Presma Anda sedang diproses.'
                        : 'Anda sudah memberikan vote untuk Presma.';
                    return;
                }

                $lockedPemilih->presma_status = Pemilih::STATUS_PENDING;
                $lockedPemilih->save();
                $willBeFinished = true;
                return;
            }

            if ($jenisVote === 'presma') {
                if (Pemilih::isLockedVoteStatus($presmaStatus)) {
                    $errorMessage = $presmaStatus === Pemilih::STATUS_PENDING
                        ? 'Vote Presma Anda sedang diproses.'
                        : 'Anda sudah memberikan vote untuk Presma.';
                    return;
                }

                $lockedPemilih->presma_status = Pemilih::STATUS_PENDING;
                $lockedPemilih->save();
                $willBeFinished = Pemilih::isLockedVoteStatus($himaStatus);
                return;
            }

            if ($jenisVote === $himaType) {
                if (Pemilih::isLockedVoteStatus($himaStatus)) {
                    $errorMessage = $himaStatus === Pemilih::STATUS_PENDING
                        ? 'Vote Himpunan Anda sedang diproses.'
                        : 'Anda sudah memberikan vote untuk Himpunan.';
                    return;
                }

                $lockedPemilih->hima_status = Pemilih::STATUS_PENDING;
                $lockedPemilih->save();
                $willBeFinished = Pemilih::isLockedVoteStatus($presmaStatus);
                return;
            }

            $errorMessage = 'Jenis vote tidak valid.';
        });

        if ($errorMessage) {
            return redirect()->back()->with('error', $errorMessage);
        }

        // Extract security context
        $ip_address = $request->ip();
        $user_agent = $request->userAgent();

        // Dispatch background job to Redis Queue (Message Broker)
        try {
            \App\Jobs\ProcessVote::dispatch($pemilih->id, $paslon->id, $jenisVote, $himaType, $ip_address, $user_agent);
        } catch (\Throwable $e) {
            $this->markVoteStatusAsFailed($pemilih->id, $jenisVote);
            return redirect()->back()->with('error', 'Gagal memproses antrean vote. Silakan coba lagi.');
        }

        // Immediate response for high throughput
        if ($willBeFinished) {
            Session::flush();
            return redirect()->route('login')->with('success', 'Vote berhasil dikirim dan sedang diproses. Terima kasih. Tunggu 1-2 menit untuk pembaruan hasil.');
        }

        return redirect()->route('menuvote', ['prodi' => $user])
            ->with('success', 'Vote berhasil dikirim ke antrean. Silakan lanjutkan hak suara lainnya atau tunggu status berubah menjadi selesai.');
    }

    private function markVoteStatusAsFailed(int $pemilihId, string $jenisVote): void
    {
        $pemilih = Pemilih::find($pemilihId);
        if (!$pemilih) {
            return;
        }

        if ($jenisVote === 'presma' && $pemilih->presma_status === Pemilih::STATUS_PENDING) {
            $pemilih->presma_status = Pemilih::STATUS_FAILED;
        }

        if ($jenisVote !== 'presma' && $pemilih->hima_status === Pemilih::STATUS_PENDING) {
            $pemilih->hima_status = Pemilih::STATUS_FAILED;
        }

        $pemilih->save();
    }
}
