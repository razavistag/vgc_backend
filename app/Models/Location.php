<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
class Location extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'location_name',
        'location_address',
        'location_city',
        'location_zip_code',
        'location_country',
        'location_phone',
        'location_status',
    ];
    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }

    public function city()
    {
        return $this->hasOne(Location::class, 'id', 'city');
    }

    public function country()
    {
        return $this->hasOne(Location::class, 'id', 'country');
    }
}
