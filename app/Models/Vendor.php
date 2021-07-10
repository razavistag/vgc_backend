<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'code',
        'contact',
        'email',
        'name',
        'agent_auto_id',
    ];
}
