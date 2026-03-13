<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    use HasFactory;

    public const STATUS_NOT_VOTED = 'not_voted';
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    protected $table = 'pemilih';

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'npm', 
        'nama', 
        'prodi', 
        'password', 
        'otp_expires_at',
        'total_vote', 
        'pml_presma', 
        'presma_status',
        'pml_hima', 
        'hima_status',
        'jenis_pemilihan',
    ];

    // Tipe data bawaan untuk casting atribut tertentu
    protected $casts = [
        'total_vote' => 'integer',
        'pml_presma' => 'integer',
        'pml_hima' => 'integer',
        'otp_expires_at' => 'datetime',
    ];

    public static function isLockedVoteStatus(?string $status): bool
    {
        return in_array($status, [self::STATUS_PENDING, self::STATUS_COMPLETED], true);
    }

    public static function defaultVoteStatus(): string
    {
        return self::STATUS_NOT_VOTED;
    }

    /**
     * Ambil daftar jenis pemilihan yang diizinkan (dari comma-separated string).
     */
    public function getAllowedVoteTypes(): array
    {
        return array_map('trim', explode(',', $this->jenis_pemilihan));
    }

    /**
     * Cek apakah pemilih bisa vote untuk jenis pemilihan tertentu.
     */
    public function canVoteFor(string $jenisPemilihan): bool
    {
        return in_array($jenisPemilihan, $this->getAllowedVoteTypes());
    }

    /**
     * Ambil paslon berdasarkan salah satu jenis pemilihan yang diizinkan.
     * Karena jenis_pemilihan comma-separated, relasi belongsTo tidak cocok.
     */
    public function paslonByJenis(string $jenisPemilihan)
    {
        return Paslon::where('jenis_pemilihan', $jenisPemilihan)->get();
    }

    /**
     * Cek apakah OTP masih valid (belum expired).
     */
    public function isOtpValid(): bool
    {
        if (!$this->otp_expires_at) {
            return true; // Jika tidak ada expiry, anggap valid (legacy data)
        }

        return $this->otp_expires_at->isFuture();
    }

    /**
     * Increment the total vote dynamically.
     */
    public function incrementVote($column)
    {
        if (in_array($column, ['pml_presma', 'pml_hima'])) {
            $this->increment($column);
            $this->total_vote = $this->pml_presma + $this->pml_hima;
            $this->save();
        }
    }

    /**
     * Decrement the total vote dynamically.
     */
    public function decrementVote($column)
    {
        if (in_array($column, ['pml_presma', 'pml_hima']) && $this->{$column} > 0) {
            $this->decrement($column);
            $this->total_vote = $this->pml_presma + $this->pml_hima;
            $this->save();
        }
    }
}
