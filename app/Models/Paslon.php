<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paslon extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi Laravel
    protected $table = 'paslon';

    // Tentukan kolom yang bisa diisi
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
}
