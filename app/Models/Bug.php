<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority',
        'type',
        'message',
        'user_id',
        'status',
        'images',
    ];

    protected $casts = [
        'images' => 'array'
    ];
}
