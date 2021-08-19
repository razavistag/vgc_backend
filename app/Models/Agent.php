<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Agent extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    // protected $fillable = [
    //     'agent_name',
    //     'agent_code',
    //     'agent_email',
    //     'agent_mobile',
    //     'agent_address',
    // ];
    protected $guarded = [];

    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }


    // protected $auditEvents = [
    //     'created',
    //     'updated',
    //     'deleted',
    //     'restored',
    // ];
}
