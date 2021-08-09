<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;

class Agent extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    protected $fillable = [
        'agent_name',
        'agent_code',
        'agent_email',
        'agent_mobile',
        'agent_address',
    ];

    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);

        return $data;
    }


    // protected $auditEvents = [
    //     'created',
    //     'updated',
    //     'deleted',
    //     'restored',
    // ];
}
