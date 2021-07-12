<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivinglogentery extends Model
{
    use HasFactory;

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

    public function Attachment()
    {
        return $this->hasMany(Attachment::class, 'document_auto_id', 'id');
    }
    public function Vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor');
    }
}
