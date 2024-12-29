<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'pemilih';
    protected $fillable = ['npm', 'nama', 'prodi', 'password', 'total_vote'];
}
