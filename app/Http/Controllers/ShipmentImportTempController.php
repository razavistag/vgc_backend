<?php

namespace App\Http\Controllers;

use App\Models\ShipmentImportTemp;
use Illuminate\Http\Request;

class ShipmentImportTempController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestObject = $request->objectRequest;
        foreach ($requestObject  as $key => $value) {
            if (isset($value['Po'])) {
                $storeObj = ShipmentImportTemp::create(
                    [
                        'Ref' => $value['Ref'],
                        'Po' => $value['Po'],
                        'Item' => $value['Item'],
                        'ColorCode' => $value['ColorCode'],
                        'ColorDescription' => $value['ColorDescription'],
                        'LC' => $value['LC'],
                        'Customer' => $value['Customer'],
                        'qty' => $value['qty'],
                        'OfCrtns' => $value['OfCrtns'],
                        'PricePerPiece' => $value['PricePerPiece'],
                        'Value' => $value['Value'],
                        'StandardCost' => $value['StandardCost'],
                        'ExtendedStandardCost' => $value['ExtendedStandardCost'],
                        'DateEntered' => $value['DateEntered'],
                        'DepartureDate' => $value['DepartureDate'],
                        'ArrivalDate' => $value['ArrivalDate'],
                        'Shipvia' => $value['Shipvia'],
                        'CarrierName' => $value['CarrierName'],
                        'Cont' => $value['Cont'],
                        'BOL' => $value['BOL'],
                        'HAWB' => $value['HAWB'],
                        'MAWB' => $value['MAWB'],
                        'WHSE' => $value['WHSE'],
                        'RcvingNumber' => $value['RcvingNumber'],
                        'PortOfEntry' => $value['PortOfEntry'],
                        'ReceivedDate' => $value['ReceivedDate'],
                        'QtyReceived' => $value['QtyReceived'],
                        'ValueReceived' => $value['ValueReceived'],
                        'ClearedCustomsDate' => $value['ClearedCustomsDate'],
                        'VendorName' => $value['VendorName'],
                        'Inv' => $value['Inv'],
                        'InvoiceDate' => $value['InvoiceDate'],
                    ]
                );
            }
        }
        return response()->json([
            'Success' => true,
            'requests' => $requestObject,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShipmentImportTemp  $shipmentImportTemp
     * @return \Illuminate\Http\Response
     */
    public function show(ShipmentImportTemp $shipmentImportTemp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipmentImportTemp  $shipmentImportTemp
     * @return \Illuminate\Http\Response
     */
    public function edit(ShipmentImportTemp $shipmentImportTemp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShipmentImportTemp  $shipmentImportTemp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipmentImportTemp $shipmentImportTemp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShipmentImportTemp  $shipmentImportTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipmentImportTemp $shipmentImportTemp)
    {
        //
    }
}
