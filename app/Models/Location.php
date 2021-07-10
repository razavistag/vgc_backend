<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_name',
        'location_address',
        'location_city',
        'location_zip_code',
        'location_country',
        'location_phone',
        'location_status',
    ];

    public function city()
    {
        return $this->hasOne(Location::class, 'id', 'city');
    }

    public function country()
    {
        return $this->hasOne(Location::class, 'id', 'country');
    }
}
