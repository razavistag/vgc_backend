<?php

namespace App\Http\Controllers;

use App\Models\OpenorderImportTemp;
use Illuminate\Http\Request;

class OpenorderImportTempController extends Controller
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
            if (isset($value['Control Number'])) {
                if ($value['Control Number'] != 'excel2json') {
                    $storeObj = OpenorderImportTemp::create(
                        [
                            'controlNumber' => $value['Control Number'],
                            'AccountingRep' => $value['Accounting Rep'],
                            'Active' => $value['Active'],
                            'Address1' => $value['Address 1'],
                            'Address2' => $value['Address 2'],
                            'AllocatedValue' => $value['Allocated Value'],
                            'Allowance' => $value['Allowance'],
                            'AllowanceAmount' => $value['Allowance Amount'],
                            'AllowancePercentageOverRide' => $value['Allowance Percentage Over Ride'],
                            'ApprovalDate' => $value['Approval Date'],
                            'BackOrder' => $value['Back Order'],
                            'Banded' => $value['Banded'],
                            'BrandCode' => $value['Brand Code'],
                            'BuyerCode' => $value['Buyer Code'],
                            'CancelDate' => $value['Cancel Date'],
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
                            'CustomCode1' => $value['Custom Code1'],
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
                            'OrderStatus' => $value['Order Status'],
                            'OrderReference' => $value['Order Reference'],
                            'OrderRemarks' => $value['Order Remarks'],
                            'OrderSalesman1Comm' => $value['Order Salesman1 Comm'],
                            'OrderSalesman2Comm' => $value['Order Salesman2 Comm'],
                            'OrderSalesman3Comm' => $value['Order Salesman3 Comm'],
                            'OrderShipVia' => $value['Order Ship Via'],
                            'OrderTerms' => $value['Order Terms'],
                            'OrderType' => $value['Order Type'],
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
                            'StartDate' => $value['Start Date'],
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
                            'CustomerVendor2' => $value['Customer Vendor2'],
                            'WebItem' => $value['Web Item'],
                            'Zip' => $value['Zip'],
                            'ordersaleman1' => $value['order saleman1'],
                            'ordersaleman2' => $value['order saleman2'],
                            'ordersaleman3' => $value['order saleman3'],
                            'flatPack' => $value['Flat Pack'],
                            'OrderStatus' => $value['Order Status'],
                        ]
                    );
                }
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
     * @param  \App\Models\OpenorderImportTemp  $openorderImportTemp
     * @return \Illuminate\Http\Response
     */
    public function show(OpenorderImportTemp $openorderImportTemp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenorderImportTemp  $openorderImportTemp
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenorderImportTemp $openorderImportTemp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenorderImportTemp  $openorderImportTemp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenorderImportTemp $openorderImportTemp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenorderImportTemp  $openorderImportTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpenorderImportTemp $openorderImportTemp)
    {
        //
    }
}
