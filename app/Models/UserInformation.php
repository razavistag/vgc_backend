<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserInformation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'user_id',
        'name',
        'contact_person',
        'contact_number',
        'email',
        'address',
        'city',
        'zip_code',
        'country',

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
