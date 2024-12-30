<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{

    use HasFactory;

    protected $table = 'pemilih';
    protected $fillable = [
        'npm', 
        'nama', 
        'prodi', 
        'password', 
        'total_vote',
        'pml_presma', 
        'pml_hima',
        'jenis_pemilihan',
    ];
}
