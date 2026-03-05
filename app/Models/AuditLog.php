<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'npm',
        'target_paslon_id',
        'jenis_vote',
        'ip_address',
        'user_agent',
        'status',
    ];
}
