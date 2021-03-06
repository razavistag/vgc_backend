<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenorderImportTemp extends Model
{
    use HasFactory;
    protected $fillable = [
        'controlNumber',
        'AccountingRep',
        'Active',
        'Address1',
        'Address2',
        'AllocatedValue',
        'Allowance',
        'AllowanceAmount',
        'AllowancePercentageOverRide',
        'ApprovalDate',
        'BackOrder',
        'Banded',
        'BrandCode',
        'BuyerCode',
        'CancelDate',
        'CancellationReason',
        'Caption',
        'CareLabelCode',
        'CartonName',
        'CartonScaleCode',
        'CartonType',
        'CartonsPerPallet',
        'Category1',
        'CategoryCode',
        'City',
        'ClassCode',
        'ColorCode',
        'Commission1',
        'Commission2',
        'Commission3',
        'CompanyCode',
        'Contact1',
        'Contact2',
        'ConversionQty',
        'CostOfTerms',
        'Country',
        'CountryOrigin',
        'CreditHold',
        'CurrencyCode',
        'CurrencyRate',
        'Currentversion',
        'CustomCode1',
        'CustomCode2',
        'CustomCode3',
        'CustomCode4',
        'CustomCode5',
        'CustomCode6',
        'CustomCode7',
        'CustomCode8',
        'CustomCode9',
        'CustomCode10',
        'CustomerAppt',
        'CustomerComments',
        'CustomerCurrencyCode',
        'CustomerFreightPaidCode',
        'CustomerItem',
        'CustomerLot',
        'CustomerName',
        'CustomerPriority',
        'CustomerProductionDate',
        'CustomerPurchaseOrder',
        'CustomerReference',
        'CustomerRelease',
        'CustomerSalesmanGroupID',
        'CustomerServiceRep',
        'CustomerShipViaCode',
        'CustomerTermsCode',
        'CustomerType',
        'CustomerVendor',
        'CustomerVendor2',
        'CustomerWarehouseCode',
        'DateAdded860',
        'DateEdited860',
        'DateEntered',
        'DateRecordModified',
        'Department',
        'DepartmentRequiredOnOrder',
        'Deptdesc',
        'Description',
        'DesignNumber',
        'DivisionCode',
        'DnBRating',
        'EDI753Required',
        'EDIFileName',
        'EDIInfo',
        'EdiAccount',
        'EdiOrder',
        'Email1',
        'Email2',
        'ExportedToAccounting',
        'FABRIC3',
        'FABRICCONTENTPRIMARY',
        'FCPrice',
        'FactorApproval',
        'FactorCode',
        'Fax1',
        'Fax2',
        'FinalDest',
        'FlagCode',
        'FreightPaidCode',
        'GLGroup',
        'Gender',
        'GroupCode',
        'HandlingCharges',
        'Hanger',
        'InHouseDate',
        'InnerPackQty',
        'InnerPolyQty',
        'InvoiceValue',
        'InvoicedValue',
        'IsHouseAccount',
        'ItemNumber',
        'Kit',
        'Label',
        'LastDateUpdated',
        'LineStatus',
        'MasterCustomer',
        'MasterGroupCode',
        'MasterItem',
        'MasterPackQty',
        'MasterUpcNumber',
        'NECKLINE/COLLAR',
        'NetAging',
        'OdetLine',
        'OpenOrderQty',
        'OpenOrderValue',
        'Options',
        'OrderCustomer',
        'OrderDetailCustomer',
        'OrderDetailCustomerPurchaseOrderNumber',
        'OrderDetailHangers',
        'OrderDetailHangtags',
        'OrderDetailPolybags',
        'OrderDetailPrice',
        'OrderDetailRemarks',
        'OrderDetailTickets',
        'OrderDetailWarehouseCode',
        'OrderPriority',
        'OrderStatus',
        'OrderReference',
        'OrderRemarks',
        // 'OrderSalesman1',
        // 'OrderSalesman2',
        // 'OrderSalesman3',
        'OrderSalesman1Comm',
        'OrderSalesman2Comm',
        'OrderSalesman3Comm',
        'OrderShipVia',
        'OrderTerms',
        'OrderType',
        'OrderValue',
        'OrderValueFC',
        'OrderWarehouseCode',
        'OrderedColorCode',
        'OrderedItem',
        'OriginalBulkQty',
        'PACK',
        'POAccessoryRemarks',
        'PRINTNumber',
        'PackPrice',
        'PackingRequiredFor753',
        'PalletName',
        'PalletQty',
        'PalletType',
        'PatternNumber',
        'Phone1',
        'Phone2',
        'PhoneInternational',
        'PolyBag',
        'PreSize',
        'PreTicket',
        'PrepackQty',
        'PreviousCustomer',
        'PrintCustomerOnAging',
        'PrintStatementOfAccount',
        'ProductID',
        'Providence',
        'QtyAllocated',
        'QtyInInnerPack',
        'QtyInvoiced',
        'QtyOrdered',
        'RNNumber',
        'Remitto',
        'RetailPrice',
        'RoutingDays',
        'RoutingGuide',
        'RoyaltyCode',
        'SLEEVELENGTH',
        'SLEEVETYPE',
        'SafetyCode',
        'SalesDivisionCode',
        'SalesmanGroupID',
        'SalesmanNumber1',
        'SalesmanNumber2',
        'SalesmanNumber3',
        'SeasonCode',
        'ShipTo',
        'Sizers',
        'StartDate',
        'State',
        'StaticApproved',
        'StaticHold',
        'Stickers',
        'Store',
        'Stuff',
        'SubGroupCode',
        'TRIM',
        'Tags',
        'TotalQuantityOrdered',
        'TotalQuantityShipped',
        'UPCNumber',
        'VendorCode',
        'VendorItemNumber',
        'WashInstr',
        'Web',
        'WebItem',
        'Zip',
        'ordersaleman1',
        'ordersaleman2',
        'ordersaleman3',
        'flatPack',
        'OrderStatus',
    ];

    public function shipment()
    {
        return $this->hasOne(ShipmentImportTemp::class, 'Item',  'ItemNumber');
    }
}
