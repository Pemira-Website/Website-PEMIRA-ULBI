<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @deprecated Model ini tidak digunakan. Gunakan Pemilih model sebagai gantinya.
 * Tidak ada migration untuk table 'Accounts'.
 * Dipertahankan untuk backward compatibility - hapus jika sudah yakin tidak direferensikan.
 */
class Accounts extends Model
{
    use HasFactory;

    protected $table = 'Accounts';
    protected $fillable = [
        'npm', 
        'nama', 
        'prodi', 
        'password', 
        'total_vote',
    ];
}
