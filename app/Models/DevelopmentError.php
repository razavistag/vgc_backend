<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevelopmentError extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_url',
        'full_url',
        'ip',
        'user_agent',
        'status',
        'message',
        'function'
    ];
}
