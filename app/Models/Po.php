<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', //--------
        'cus_po_number', //--------
        'po_number', //--------
        'style', //--------
        'customer', //--------
        'customer_email',  //--------
        'agent', //--------
        'agent_email', //--------
        'agent_code', //--------
        'receiver', //--------
        'receiver_email', //--------
        'priority', //--------
        'customer_auto_id', //--------
        'agent_auto_id',    //--------
        'receiver_auto_id', //--------
        'company_auto_id',
        'company', //--------
        'number_of_style', //--------
        'qty', //--------
        'total_value', //--------
        'attachment_auto_id', //--------
        'control_number', //--------
        'po_request_date', //--------
        'po_date', //--------
        'house_date', //--------
        'cancel_date', //--------
        'ex_fty_date', //--------
        'vendor', //--------
        'vendor_email', //--------
        'vendor_code', //--------
        'beneficiary', //--------
        'payment_term', //--------
        'load_port', //--------
        'port_of_entry', //--------
        'ship_via', //--------
        'hanger', //--------
        'instruction', //--------
        'cost_type', //--------
        'warehouse', //--------
        'vendor_auto_id', //--------
        'hanger_cost', //--------
        'season', //--------
        'po_subject',
        'completed_by', //--------
        'completed_by_email', //--------
        'approved_by', //--------
    ];

    public function Customer()
    {
        return $this->hasOne(Customer::class, 'id',  'customer_auto_id');
    }
    public function Vendor()
    {
        return $this->hasOne(Vendor::class, 'id',  'vendor_auto_id');
    }
    public function Agent()
    {
        return $this->hasOne(Agent::class, 'id',  'agent_auto_id');
    }
    public function Attachment()
    {
        return $this->hasMany(Attachment::class, 'document_auto_id');
    }
    public function CompletedBy()
    {
        return $this->hasOne(User::class, 'id', 'completed_by');
    }
    public function approvedBy()
    {
        return $this->hasOne(User::class, 'id', 'approved_by');
    }
    public function RequestedBy()
    {
        return $this->hasOne(User::class, 'id', 'receiver_auto_id');
    }
}
