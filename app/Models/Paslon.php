<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paslon extends Model
{
    use HasFactory;

    protected $table = 'paslon';

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'paslon_ke',
        'nm_ketua',
        'nm_wakil',
        'ft_ketua',
        'ft_wakil',
        'npm_ketua',
        'npm_wakil',
        'pd_ketua',
        'pd_wakil',
        'ang_ketua',
        'jbt_ketua',
        'ang_wakil',
        'jbt_wakil',
        'visi',
        'misi',
        'jenis_pemilihan',
        'total_vote',
    ];

    // Tipe data bawaan untuk casting atribut tertentu
    protected $casts = [
        'total_vote' => 'integer',
    ];

    // Relasi ke model Pemilih (opsional, tambahkan jika ada hubungan antar tabel)
    public function pemilih()
    {
        return $this->hasMany(Pemilih::class, 'jenis_pemilihan', 'jenis_pemilihan');
    }

    /**
     * Increment the total vote dynamically.
     */
    public function incrementTotalVote()
    {
        $this->increment('total_vote');
    }

    /**
     * Decrement the total vote dynamically.
     */
    public function decrementTotalVote()
    {
        if ($this->total_vote > 0) {
            $this->decrement('total_vote');
        }
    }
}
