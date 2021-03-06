<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Vendor extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'address',
        'code',
        'contact',
        'email',
        'name',
        'agent_auto_id',
    ];

    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }
}
