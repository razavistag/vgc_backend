<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'order_date',              // -> orderDate
        'cancel_date',             // -> cancelDate
        'comment',
        'remark',
        'customer_auto_id',        //  -> customer
        'customer',                // |
        'customer_email',          // |
        'sales_rep_auto_id',       // ->  salesRep
        'sales_rep',               // |
        'sales_rep_email',         // |
        'po_number',               // -> po_number
        'factor_number',
        'receiver',
        'receiver_email',
        'completed_by',             // -> company
        'completed_by_email',
        'approved_by',
        'num_page',
        'production_by',            // -> production
        'production_auto_id',       // |
        'production_email',         // |
        'company_auto_id',          // ->company
        'control_number',           // -> control_number
        'number_of_style',
        'receiver_auto_id',
        'status',
        'order_type',               // -> type
        'is_immediate',
        'edi_status',               // -> edi
        'upc_status',               // -> upc
        'price_ticket',             // -> pt
        'total_value',              // -> nop
        'or_style',                 // -> or_style
        're_style',                 // -> re_style
        'eta',                      // -> date only
    ];

    public function Attachment()
    {
        return $this->hasMany(Attachment::class, 'document_auto_id');
    }
    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_auto_id');
    }

    public function salesrap()
    {
        return $this->hasOne(User::class, 'id', 'sales_rep_auto_id');
    }

    public function production()
    {
        return $this->hasOne(User::class, 'id', 'production_auto_id');
    }
}
