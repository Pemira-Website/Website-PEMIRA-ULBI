<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    use HasFactory;

    protected $table = 'pemilih';

    // Kolom yang dapat diisi (mass assignment)
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

    // Tipe data bawaan untuk casting atribut tertentu
    protected $casts = [
        'total_vote' => 'integer',
        'pml_presma' => 'integer',
        'pml_hima' => 'integer',
    ];

    // Relasi ke model Paslon (opsional, tambahkan jika ada hubungan antar tabel)
    public function paslon()
    {
        return $this->belongsTo(Paslon::class, 'jenis_pemilihan', 'jenis_pemilihan');
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
