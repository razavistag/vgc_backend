<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentImportTemp extends Model
{
    use HasFactory;
    protected $fillable = [
        'Ref',
        'Po',
        'Item',
        'ColorCode',
        'ColorDescription',
        'LC',
        'Customer',
        'qty',
        'OfCrtns',
        'PricePerPiece',
        'Value',
        'StandardCost',
        'ExtendedStandardCost',
        'DateEntered',
        'DepartureDate',
        'ArrivalDate',
        'Shipvia',
        'CarrierName',
        'Cont',
        'BOL',
        'HAWB ',
        'MAWB',
        'WHSE',
        'RcvingNumber',
        'PortOfEntry',
        'ReceivedDate',
        'QtyReceived',
        'ValueReceived',
        'ClearedCustomsDate',
        'VendorName',
        'Inv',
        'InvoiceDate',
    ];

    public function Openorder()
    {
        $object = $this->hasOneThrough(OpenorderImportTemp::class, 'ItemNumber',  'Item');
        return $object;
    }
}
