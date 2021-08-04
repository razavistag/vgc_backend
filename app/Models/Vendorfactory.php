<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendorfactory extends Model
{
    use HasFactory;

    protected $fillable = [
        'factory_name',
        'factory_code',
        'factory_mobile',
        'factory_email',
        'factory_address',
        'vendor_auto_id',
        'vendor_name'
    ];

    public function user()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_auto_id');
    }
}
