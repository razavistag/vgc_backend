<?php

namespace App\Http\Controllers;

use App\Models\OpenOrder;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpenOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $objFetch = OpenOrder::select( 
                'id', 
                'program',
                'controlNumber',
                'CustomerName',
                'OrderDetailCustomerPurchaseOrderNumber',
                'masterpo',
                'TotalQuantityOrdered',
                'style',
                'StartDate',
                'CancelDate',
                'newCancelDate',
                'PTorSend',
                'Complete_partial',
                'Routed',
                'SHIPPED',
                'RoutingDate',
                'PICKUPAPPTime',
                'InHouseDate',
                'ActualETA',
                // FPO AND shipment 
                // Container
                'Containerreceived',
                // WBCT DATE
                'notes',
                // buyer NAME 
                // OTHER NOTE 
                // PROGRAM @ 
            )->orderby('id', 'desc')
                ->where('SHIPPED', '!=', 'YES')
                ->where('controlNumber', '!=', 0)
                ->paginate(20);



            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
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

    public function masterSearch(Request $request){

        try {
            $objFetch = OpenOrder::select( 
                'id', 
                'program',
                'controlNumber',
                'CustomerName',
                'OrderDetailCustomerPurchaseOrderNumber',
                'masterpo',
                'TotalQuantityOrdered',
                'style',
                'StartDate',
                'CancelDate',
                'newCancelDate',
                'PTorSend',
                'Complete_partial',
                'Routed',
                'SHIPPED',
                'RoutingDate',
                'PICKUPAPPTime',
                'InHouseDate',
                'ActualETA',
                // FPO AND shipment 
                // Container
                'Containerreceived',
                // WBCT DATE
                'notes',
                // buyer NAME 
                // OTHER NOTE 
                // PROGRAM @ 
            ) 
            ->where('controlNumber', '!=', 0)
            ->where('SHIPPED', '!=', 'YES')
            ->where('program',  'like', '%' . $request->search. '%')
            ->orWhere('style',  'like', '%' . $request->search. '%')
            ->orWhere('controlNumber',  'like', '%' . $request->search. '%')
            ->orWhere('CustomerName',  'like', '%' . $request->search. '%')
            ->orWhere('OrderDetailCustomerPurchaseOrderNumber',  'like', '%' . $request->search. '%')
            ->orWhere('masterpo',  'like', '%' . $request->search. '%')
            ->orWhere('TotalQuantityOrdered',  'like', '%' . $request->search. '%')
            ->orWhere('Complete_partial',  'like', '%' . $request->search. '%')
            ->orWhere('PTorSend',  'like', '%' . $request->search. '%')
            ->orWhere('SHIPPED',  'like', '%' . $request->search. '%')
            ->get();



            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function sortasc(Request $request){
        try {
            $objFetch = OpenOrder::select( 
                'id', 
                'program',
                'controlNumber',
                'CustomerName',
                'OrderDetailCustomerPurchaseOrderNumber',
                'masterpo',
                'TotalQuantityOrdered',
                'style',
                'StartDate',
                'CancelDate',
                'newCancelDate',
                'PTorSend',
                'Complete_partial',
                'Routed',
                'SHIPPED',
                'RoutingDate',
                'PICKUPAPPTime',
                'InHouseDate',
                'ActualETA',
                // FPO AND shipment 
                // Container
                'Containerreceived',
                // WBCT DATE
                'notes',
                // buyer NAME 
                // OTHER NOTE 
                // PROGRAM @ 
             )->orderby($request->sort, 'asc')
                ->where('SHIPPED', '!=', 'YES')
                ->where('controlNumber', '!=', 0)
                ->get();



            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
                'e' => $e,
            ], 500);
        }
    }

    public function sorting(Request $request){
       
        
            $sortOrder = $request->sortOrder;
             if ($sortOrder == true) {
               return $sortOrder = 'asc';
             }else{
                return $sortOrder = 'desc';
             }

           

            $objFetch = OpenOrder::select( 
                'id', 
                'program',
                'controlNumber',
                'CustomerName',
                'OrderDetailCustomerPurchaseOrderNumber',
                'masterpo',
                'TotalQuantityOrdered',
                'style',
                'StartDate',
                'CancelDate',
                'newCancelDate',
                'PTorSend',
                'Complete_partial',
                'Routed',
                'SHIPPED',
                'RoutingDate',
                'PICKUPAPPTime',
                'InHouseDate',
                'ActualETA',
                // FPO AND shipment 
                // Container
                'Containerreceived',
                // WBCT DATE
                'notes',
                // buyer NAME 
                // OTHER NOTE 
                // PROGRAM @ 
             )->orderby($request->sortValue,  $sortOrder)
                ->where('SHIPPED', '!=', 'YES')
                ->where('controlNumber', '!=', 0)
                ->get();



            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
       
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $req = $request->all();

        $requestObject = $request->objectRequest;

        foreach ($requestObject  as $key => $value) {
            if (isset($value['Control Number'])) {
                if ($value['Control Number'] != '0') {
                    // return 0;
                    $checkControlNumber = OpenOrder::take(1)->where('controlNumber', $value['Control Number'])->first();
                    if ($checkControlNumber == null) {
                        $timestamp = strtotime($value['Start Date']);
                        $storeObj = OpenOrder::create(
                            [
                                'controlNumber' => $value['Control Number'],
                                'AccountingRep' => $value['Accounting Rep'],
                                'Active' => $value['Active'],
                                'Address1' => $value['Address 1'],
                                'Address2' => $value['Address 2'],
                                'AllocatedValue' => $value['Allocated Value'],
                                'Allowance%' => $value['Allowance'],
                                'AllowanceAmount' => $value['Allowance Amount'],
                                'AllowancePercentageOverRide' => $value['Allowance Percentage Over Ride'],
                                'ApprovalDate' => $value['Approval Date'],
                                'BackOrder' => $value['Back Order'],
                                'Banded' => $value['Banded'],

                                'BuyerCode' => $value['Buyer Code'],
                                // 'CancelDate' => $value['Cancel Date'],
                                'CancelDate' => strtotime($value['Cancel Date']),
                                'CancellationReason' => $value['Cancellation Reason'],
                                'Caption' => $value['Caption'],
                                'CareLabelCode' => $value['Care Label Code'],
                                'CartonName' => $value['Carton Name'],
                                'CartonScaleCode' => $value['Carton Scale Code'],
                                'CartonType' => $value['Carton Type'],
                                'CartonsPerPallet' => $value['Cartons Per Pallet'],
                                'Category1' => $value['Category 1'],
                                'CategoryCode' => $value['Category Code'],
                                'City' => $value['City'],
                                'ClassCode' => $value['Class Code'],
                                'ColorCode' => $value['Color Code'],
                                'Commission1' => $value['Commission 1'],
                                'Commission2' => $value['Commission 2'],
                                'Commission3' => $value['Commission 3'],
                                'CompanyCode' => $value['Company Code'],
                                'Contact1' => $value['Contact 1'],
                                'Contact2' => $value['Contact 2'],
                                'ConversionQty' => $value['Conversion Qty'],
                                'CostOfTerms' => $value['Cost Of Terms'],
                                'Country' => $value['Country'],
                                'CountryOrigin' => $value['Country Origin'],
                                'CreditHold' => $value['Credit Hold'],
                                'CurrencyCode' => $value['Currency Code'],
                                'CurrencyRate' => $value['Currency Rate'],
                                'Currentversion' => $value['Current version'],
                                'CustomCode2' => $value['Custom Code2'],
                                'CustomCode3' => $value['Custom Code3'],
                                'CustomCode4' => $value['Custom Code4'],
                                'CustomCode5' => $value['Custom Code5'],
                                'CustomCode6' => $value['Custom Code6'],
                                'CustomCode7' => $value['Custom Code7'],
                                'CustomCode8' => $value['Custom Code8'],
                                'CustomCode9' => $value['Custom Code9'],
                                'CustomCode10' => $value['Custom Code10'],
                                'CustomerAppt' => $value['Customer Appt'],
                                'CustomerComments' => $value['Customer Comments'],
                                'CustomerCurrencyCode' => $value['Customer Currency Code'],
                                'CustomerFreightPaidCode' => $value['Customer Freight Paid Code'],
                                'CustomerItem' => $value['Customer Item'],
                                'CustomerLot' => $value['Customer Lot'],
                                'CustomerName' => $value['Customer Name'],
                                'CustomerPriority' => $value['Customer Priority'],
                                'CustomerProductionDate' => $value['Customer Production Date'],
                                'CustomerPurchaseOrder' => $value['Customer Purchase Order'],
                                'CustomerReference' => $value['Customer Reference'],
                                'CustomerRelease' => $value['Customer Release'],
                                'CustomerSalesmanGroupID' => $value['Customer Salesman Group ID'],
                                'CustomerServiceRep' => $value['Customer Service Rep'],
                                'CustomerShipViaCode' => $value['Customer Ship Via Code'],
                                'CustomerTermsCode' => $value['Customer Terms Code'],
                                'CustomerType' => $value['Customer Type'],
                                'CustomerVendor' => $value['Customer Vendor'],
                                // 'CustomerVendor1' => $value['Customer Vendor 1'],
                                'CustomerWarehouseCode' => $value['Customer Warehouse Code'],
                                'DateAdded860' => $value['Date Added 860'],
                                'DateEdited860' => $value['Date Edited 860'],
                                'DateEntered' => $value['Date Entered'],
                                'DateRecordModified' => $value['Date Record Modified'],
                                'Department' => $value['Department'],
                                'DepartmentRequiredOnOrder' => $value['Department Required On Order'],
                                'Deptdesc' => $value['Dept desc'],
                                'Description' => $value['Description'],
                                'DesignNumber' => $value['Design Number'],
                                'DivisionCode' => $value['Division Code'],
                                'DnBRating' => $value['Dn B Rating'],
                                'EDI753Required' => $value['EDI 753Required'],
                                'EDIFileName' => $value['EDI File Name'],
                                'EDIInfo' => $value['EDI Info'],
                                'EdiAccount' => $value['Edi Account'],
                                'EdiOrder' => $value['Edi Order'],
                                'Email1' => $value['Email 1'],
                                'Email2' => $value['Email 2'],
                                'ExportedToAccounting' => $value['Exported To Accounting'],
                                'FABRIC3' => $value['FABRIC 3'],
                                'FABRICCONTENTPRIMARY' => $value['FABRIC CONTENT PRIMARY'],
                                'FCPrice' => $value['FC Price'],
                                'FactorApproval' => $value['Factor Approval'],
                                'FactorCode' => $value['Factor Code'],
                                'Fax1' => $value['Fax 1'],
                                'Fax2' => $value['Fax 2'],
                                'FinalDest' => $value['Final Dest'],
                                'FlagCode' => $value['Flag Code'],
                                'FreightPaidCode' => $value['Freight Paid Code'],
                                'GLGroup' => $value['GL Group'],
                                'Gender' => $value['Gender'],
                                'GroupCode' => $value['Group Code'],
                                'HandlingCharges' => $value['Handling Charges'],
                                'Hanger' => $value['Hanger'],
                                'InHouseDate' => $value['In House Date'],
                                'InnerPackQty' => $value['Inner Pack Qty'],
                                'InnerPolyQty' => $value['Inner Poly Qty'],
                                'InvoiceValue' => $value['Invoice Value'],
                                'InvoicedValue' => $value['Invoiced Value'],
                                'IsHouseAccount' => $value['Is House Account'],
                                'ItemNumber' => $value['Item Number'],
                                'Kit' => $value['Kit'],
                                'Label' => $value['Label'],
                                'LastDateUpdated' => $value['Last Date Updated'],
                                'LineStatus' => $value['Line Status'],
                                'MasterCustomer' => $value['Master Customer'],
                                'MasterGroupCode' => $value['Master Group Code'],
                                'MasterItem' => $value['Master Item'],
                                'MasterPackQty' => $value['Master Pack Qty'],
                                'MasterUpcNumber' => $value['Master Upc Number'],
                                'NECKLINE/COLLAR' => $value['NECKLINE/COLLAR'],
                                'NetAging' => $value['Net Aging'],
                                'OdetLine' => $value['Odet Line'],
                                'OpenOrderQty' => $value['Open Order Qty'],
                                'OpenOrderValue' => $value['Open Order Value'],
                                'Options' => $value['Options'],
                                'OrderCustomer' => $value['Order Customer'],
                                'OrderDetailCustomer' => $value['Order Detail Customer'],
                                'OrderDetailCustomerPurchaseOrderNumber' => $value['Order Detail Customer Purchase Order Number'],
                                'OrderDetailHangers' => $value['Order Detail Hangers'],
                                'OrderDetailHangtags' => $value['Order Detail Hangtags'],
                                'OrderDetailPolybags' => $value['Order Detail Polybags'],
                                'OrderDetailPrice' => $value['Order Detail Price'],
                                'OrderDetailRemarks' => $value['Order Detail Remarks'],
                                'OrderDetailTickets' => $value['Order Detail Tickets'],
                                'OrderDetailWarehouseCode' => $value['Order Detail Warehouse Code'],
                                'OrderPriority' => $value['Order Priority'],
                                'OrderReference' => $value['Order Reference'],
                                'OrderRemarks' => $value['Order Remarks'],
                                'OrderSalesman1Comm' => $value['Order Salesman1 Comm'],
                                'OrderSalesman2Comm' => $value['Order Salesman2 Comm'],
                                'OrderSalesman3Comm' => $value['Order Salesman3 Comm'],
                                'OrderShipVia' => $value['Order Ship Via'],
                                'OrderTerms' => $value['Order Terms'],
                                'OrderType' => $value['Order Type'],
                                'OrderStatus' => $value['Order Status'],
                                'OrderValue' => $value['Order Value'],
                                'OrderValueFC' => $value['Order Value FC'],
                                'OrderWarehouseCode' => $value['Order Warehouse Code'],
                                'OrderedColorCode' => $value['Ordered Color Code'],
                                'OrderedItem' => $value['Ordered Item'],
                                'OriginalBulkQty' => $value['Original Bulk Qty'],
                                'PACK' => $value['PACK'],
                                'POAccessoryRemarks' => $value['PO Accessory Remarks'],
                                'PRINTNumber' => $value['PRINT Number'],
                                'PackPrice' => $value['Pack Price'],
                                'PackingRequiredFor753' => $value['Packing Required For753'],
                                'PalletName' => $value['Pallet Name'],
                                'PalletQty' => $value['Pallet Qty'],
                                'PalletType' => $value['Pallet Type'],
                                'PatternNumber' => $value['Pattern Number'],
                                'Phone1' => $value['Phone 1'],
                                'Phone2' => $value['Phone 2'],
                                'PhoneInternational' => $value['Phone International'],
                                'PolyBag' => $value['Poly Bag'],
                                'PreSize' => $value['Pre Size'],
                                'PreTicket' => $value['Pre Ticket'],
                                'PrepackQty' => $value['Prepack Qty'],
                                'PreviousCustomer' => $value['Previous Customer'],
                                'PrintCustomerOnAging' => $value['Print Customer On Aging'],
                                'PrintStatementOfAccount' => $value['Print Statement Of Account'],
                                'ProductID' => $value['Product ID'],
                                'Providence' => $value['Providence'],
                                'QtyAllocated' => $value['Qty Allocated'],
                                'QtyInInnerPack' => $value['Qty In Inner Pack'],
                                'QtyInvoiced' => $value['Qty Invoiced'],
                                'QtyOrdered' => $value['Qty Ordered'],
                                'RNNumber' => $value['RNNumber'],
                                'Remitto' => $value['Remit to'],
                                'RetailPrice' => $value['Retail Price'],
                                'RoutingDays' => $value['Routing Days'],
                                'RoutingGuide' => $value['Routing Guide'],
                                'RoyaltyCode' => $value['Royalty Code'],
                                'SLEEVELENGTH' => $value['SLEEVE LENGTH'],
                                'SLEEVETYPE' => $value['SLEEVE TYPE'],
                                'SafetyCode' => $value['Safety Code'],
                                'SalesDivisionCode' => $value['Sales Division Code'],
                                'SalesmanGroupID' => $value['Salesman Group ID'],
                                'SalesmanNumber1' => $value['Salesman Number 1'],
                                'SalesmanNumber2' => $value['Salesman Number 2'],
                                'SalesmanNumber3' => $value['Salesman Number 3'],
                                'SeasonCode' => $value['Season Code'],
                                'ShipTo' => $value['Ship To'],
                                'Sizers' => $value['Sizers'],
                                // 'StartDate' => $value['Start Date'],
                                'StartDate' => strtotime($value['Start Date']),
                                'State' => $value['State'],
                                'StaticApproved' => $value['Static Approved'],
                                'StaticHold' => $value['Static Hold'],
                                'Stickers' => $value['Stickers'],
                                'Store' => $value['Store'],
                                'Stuff' => $value['Stuff'],
                                'SubGroupCode' => $value['Sub Group Code'],
                                'TRIM' => $value['TRIM'],
                                'Tags' => $value['Tags'],
                                'TotalQuantityOrdered' => $value['Total Quantity Ordered'],
                                'TotalQuantityShipped' => $value['Total Quantity Shipped'],
                                'UPCNumber' => $value['UPC Number'],
                                'VendorCode' => $value['Vendor Code'],
                                'VendorItemNumber' => $value['Vendor Item Number'],
                                'WashInstr' => $value['Wash Instr'],
                                'Web' => $value['Web'],
                                'WebItem' => $value['Web Item'],
                                'Zip' => $value['Zip'],
                                'ordersaleman1' => $value['order saleman1'],
                                'ordersaleman2' => $value['order saleman2'],
                                'ordersaleman3' => $value['order saleman3'],
                                'subCompany' => $value['Sub Company'],
                                'program' => $value['Program'],
                                'Seasons' => $value['Seasons'],
                                // 'newCancelDate' => $value['New Cancel Date'],
                                'newCancelDate' => strtotime($value['New Cancel Date']),
                                'masterpo' => substr($value['Order Detail Customer Purchase Order Number'], -6),
                                // 'RoutingDate' => $value['Routing Date'],
                                'RoutingDate' =>   strtotime($value['Routing Date']),
                                // 'PICKUPAPPTime' => $value['PICKUP APP Time'],
                                'PICKUPAPPTime' =>  strtotime($value['PICKUP APP Time']),
                                // 'ActualETA' => $value['Actual ETA'],
                                'ActualETA' => strtotime($value['Actual ETA']),
                                'notes' => $value['NOTES FOR ALBERT / RENEE / MELANIE'],
                                'PTorSend' => $value['PT or Send'],
                                'Complete_partial' => $value['Complete/partial'],
                                'Routed' => $value['Routed'],
                                'SHIPPED' => $value['SHIPPED'],
                                'Containerreceived' => $value['Container received'],
                            ]
                        );
                    }
                }
            }
        }

        return response()->json([
            'Success' => true,
            'requests' => $requestObject,
        ]);
    }

    /**
     * Display the filtered data .
     *
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $timestamp_Start = strtotime($request->startDate_start);
        $timestamp_End = strtotime($request->startDate_end);


        try {

            // filter companies
            if ($request->majorCompanies != '' && $request->cancelDate_start == '' && $request->startDate_start == '' && $request->newCancelDate_start == '') {
                $objFetch = OpenOrder::where('OrderCustomer', $request->majorCompanies)
                    ->orderby('id', 'desc')->get();
            }

            // filter start date
            if ($request->startDate_start != '') {
                $objFetch = OpenOrder::where('OrderCustomer', $request->majorCompanies)
                    ->whereBetween(
                        'StartDate',
                        array($timestamp_Start, $timestamp_End)
                    )
                    ->orderby('id', 'desc')->get();
            }

            // filter cancel date
            if ($request->cancelDate_start != '' && $request->startDate_start == '') {

                $objFetch = OpenOrder::where('OrderCustomer', $request->majorCompanies)
                    ->whereBetween(
                        'CancelDate',
                        array(strtotime($request->cancelDate_start), strtotime($request->cancelDate_end))
                    )
                    ->orderby('id', 'desc')->get();
            }

            // filter new cancel date
            if ($request->newCancelDate_start != '' && $request->cancelDate_start == '' && $request->startDate_start == '') {
                $objFetch = OpenOrder::where('OrderCustomer', $request->majorCompanies)
                    ->whereBetween(
                        'newCancelDate',
                        array(strtotime($request->newCancelDate_start), strtotime($request->newCancelDate_end))

                    )
                    ->orderby('id', 'desc')->get();
            }

            // filter cancel date, start date, new cancel date
            if ($request->cancelDate_start != '' && $request->startDate_start != '' && $request->newCancelDate_start != '') {
                $objFetch = OpenOrder::where('OrderCustomer', $request->majorCompanies)
                    ->whereBetween(
                        'StartDate',
                        array($timestamp_Start, $timestamp_End)
                    )
                    ->whereBetween(
                        'CancelDate',
                        array(strtotime($request->cancelDate_start), strtotime($request->cancelDate_end))
                    )
                    ->orderby('id', 'desc')->get();
            }

            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    /**
     * Display the Major Company .
     *
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function majorCompany(OpenOrder $openOrder)
    {
        $objectFind = OpenOrder::orderby('id', 'desc')
            ->select('OrderCustomer')
            ->where('OrderCustomer', '!=', 'excel2json')
            ->distinct('OrderCustomer')
            ->get();

        return response()->json([
            'success' => true,
            'objects' => $objectFind
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function show($openOrder)
    {
        $objectFind = OpenOrder::select(
            'id',
            'program',
            'newCancelDate',
            'RoutingDate',
            'PICKUPAPPTime',
            'ActualETA',
            'Complete_partial',
            'Routed',
            'SHIPPED',
            'Containerreceived',
            'notes',

            // 'CompanyCode',
            // 'DivisionCode',
            // 'controlNumber',
            // 'StartDate',
            // 'CancelDate',
            // 'PTorSend',
            // 'PICKUPAPPTime',
            // 'BuyerCode',
        )->where('id', $openOrder)
            ->first();

        return response()->json([
            'success' => true,
            'objects' => $objectFind
        ]);
    }

    /**
     * updating styles on open order table
     * if style of open order data and shipment data
     * are matched we update the style value of the shipment data
     * into open order column on open order table
     */
    public function styleCheckUpdate($id,Request $request)
    {
        $requestObject = $request->objectRequest;
        foreach ($requestObject  as $key => $value) {
            $checkStyle = OpenOrder::where('ItemNumber', $value['Item'])
                ->update([
                    'style' => $value['Item']
                ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Shipment styles updated',
            'objects' => $requestObject
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($openOrder)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $openOrder)
    {
        $updateObj = OpenOrder::where('id', $openOrder)
            ->update($request->all());

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Recode updated successfully',
            'data' => $updateObj,

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenOrder  $openOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($openOrder)
    {
        //
        DB::beginTransaction();
        try {
            $obj = OpenOrder::find($openOrder);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Recode Successfully Deleted'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }
}
