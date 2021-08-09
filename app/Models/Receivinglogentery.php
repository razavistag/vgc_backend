<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Receivinglogentery extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'status',
        'division',
        'vendor',
        'amt_shipment',
        'container',
        'po',
        'etd_date',
        'eta_date',
        'est_eta_war_date',
        'actual_eta_war_date',
        'tally_date',
        'sys_rec_date',
        'appointment_no',
        'trucker',
        'carton',
        'pcs',
        'wh_charge',
        'miss',
        'current_note',
        'status_note',
    ];
    public function transformAudit(array $data): array
    {
        Arr::set($data, 'recode_auto_id',  $this->attributes['id']);
        Arr::set($data, 'user_name',  Auth::user()->name);

        return $data;
    }

    public function Attachment()
    {
        return $this->hasMany(Attachment::class, 'document_auto_id', 'id');
    }
    public function Vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor');
    }
}
