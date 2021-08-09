<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Vendorfactory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'factory_name',
        'factory_code',
        'factory_mobile',
        'factory_email',
        'factory_address',
        'vendor_auto_id',
        'vendor_name'
    ];

    // protected $auditInclude  = [
    //     'factory_name', 'factory_code', 'factory_mobile', 'updated_at'
    // ];
    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }

    public function user()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_auto_id');
    }
}
