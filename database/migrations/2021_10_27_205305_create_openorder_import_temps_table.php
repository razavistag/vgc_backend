<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenorderImportTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openorder_import_temps', function (Blueprint $table) {
            $table->id();
            $table->string('CompanyCode', 20)->nullable();
            $table->string('DivisionCode', 20)->nullable();
            $table->string('ControlNumber', 20)->nullable();
            $table->string('CurrencyCode', 10)->nullable();
            $table->string('OrderWarehouseCode', 20)->nullable();
            $table->string('OrderCustomer', 100)->nullable();
            $table->string('DateEntered', 50)->nullable();
            $table->string('TotalQuantityOrdered', 100)->nullable();
            $table->string('TotalQuantityShipped', 100)->nullable();
            $table->string('OrderType', 10)->nullable();
            $table->string('OrderTerms', 10)->nullable();
            $table->string('OrderShipVia', 20)->nullable();
            $table->string('OrderPriority', 5)->nullable();
            $table->string('Department', 10)->nullable();
            $table->string('FactorCode', 10)->nullable();
            $table->string('FactorApproval', 100)->nullable();
            $table->string('ApprovalDate', 50)->nullable();
            $table->integer('OrderStatus')->nullable();
            $table->string('FreightPaidCode', 10)->nullable();
            $table->string('StartDate', 50)->nullable();
            $table->string('CancelDate', 50)->nullable();
            $table->string('InHouseDate', 50)->nullable();
            $table->double('OrderValue')->nullable();
            $table->string('EdiOrder', 5)->nullable();
            $table->string('CustomerReference', 100)->nullable();
            $table->string('CustomerRelease', 100)->nullable();
            $table->string('CustomerVendor2')->nullable();
            $table->string('CustomerAppt', 100)->nullable();
            $table->string('CustomerLot')->nullable();
            $table->string('CustomerProductionDate', 50)->nullable();
            $table->string('SalesDivisionCode', 15)->nullable();
            $table->string('Allowance', 50)->nullable();
            $table->string('AllowanceAmount', 50)->nullable();
            $table->string('BuyerCode', 100)->nullable();
            $table->string('FinalDest', 100)->nullable();
            $table->double('OrderValueFC')->nullable();
            $table->double('CurrencyRate')->nullable();
            $table->string('OrderRemarks', 200)->nullable();
            $table->string('Deptdesc', 15)->nullable();
            $table->string('ordersaleman1')->nullable();
            $table->string('ordersaleman2')->nullable();
            $table->string('ordersaleman3')->nullable();
            $table->double('OrderSalesman1Comm')->nullable();
            $table->double('OrderSalesman2Comm')->nullable();
            $table->double('OrderSalesman3Comm')->nullable();
            $table->integer('ShipTo')->nullable();
            $table->integer('CustomerPurchaseOrder')->nullable();
            $table->double('InvoiceValue')->nullable();
            $table->string('EDIFileName', 100)->nullable();
            $table->integer('Currentversion')->nullable();
            $table->integer('SalesmanGroupID')->nullable();
            $table->string('StaticApproved', 100)->nullable();
            $table->string('AllowancePercentageOverRide', 10)->nullable();
            $table->string('StaticHold', 10)->nullable();
            $table->double('HandlingCharges')->nullable();
            $table->string('OrderReference', 50)->nullable();
            $table->integer('OdetLine')->nullable();
            $table->string('ItemNumber')->nullable();
            $table->string('ColorCode', 50)->nullable();
            $table->integer('OrderDetailWarehouseCode')->nullable();
            $table->string('OrderDetailCustomer', 50)->nullable();
            $table->string('CustomerItem', 100)->nullable();
            $table->string('Kit', 100)->nullable();
            $table->integer('Store')->nullable();
            $table->integer('LineStatus')->nullable();
            $table->double('OrderDetailPrice')->nullable();
            $table->double('PackPrice')->nullable();
            $table->double('FCPrice')->nullable();
            $table->string('RetailPrice')->nullable();
            $table->integer('PrepackQty')->nullable();
            $table->integer('MasterPackQty')->nullable();
            $table->integer('InnerPackQty')->nullable();
            $table->integer('QtyInInnerPack')->nullable();
            $table->string('PalletType', 50)->nullable();
            $table->string('PalletName', 50)->nullable();
            $table->integer('PalletQty')->nufllable();
            $table->string('CartonType', 100)->nullable();
            $table->string('CartonName', 100)->nullable();
            $table->integer('CartonsPerPallet')->nullable();
            $table->string('OrderDetailHangtags', 50)->nullable();
            $table->integer('OrderDetailTickets')->nullable();
            $table->string('OrderDetailHangers', 50)->nullable();
            $table->string('OrderDetailPolybags', 50)->nullable();
            $table->integer('OrderDetailCustomerPurchaseOrderNumber')->nullable();
            $table->string('OrderDetailRemarks', 100)->nullable();
            $table->string('DateRecordModified', 100)->nullable();
            $table->string('CancellationReason', 200)->nullable();
            $table->integer('OriginalBulkQty')->nullable();
            $table->integer('InnerPolyQty')->nullable();
            $table->string('OrderedItem', 100)->nullable();
            $table->string('OrderedColorCode', 50)->nullable();
            $table->string('DateAdded860', 50)->nullable();
            $table->string('DateEdited860', 50)->nullable();
            $table->integer('ProductID')->nullable();
            $table->integer('ConversionQty')->nullable();
            $table->integer('CustomerWarehouseCode')->nullable();
            $table->string('CustomerTermsCode', 50)->nullable();
            $table->string('CustomerShipViaCode', 50)->nullable();
            $table->string('SalesmanNumber1', 50)->nullable();
            $table->string('SalesmanNumber2', 50)->nullable();
            $table->string('SalesmanNumber3', 50)->nullable();
            $table->string('CustomerName', 70)->nullable();
            $table->string('Address1', 100)->nullable();
            $table->string('Address2', 100)->nullable();
            $table->string('City', 40)->nullable();
            $table->string('State', 40)->nullable();
            $table->integer('Zip')->nullable();
            $table->string('Country', 10)->nullable();
            $table->string('Providence', 70)->nullable();
            $table->string('Contact1', 20)->nullable();
            $table->string('Phone1', 20)->nullable();
            $table->string('Fax1', 20)->nullable();
            $table->string('Email1', 60)->nullable();
            $table->string('Contact2', 20)->nullable();
            $table->string('Phone2', 20)->nullable();
            $table->string('Fax2', 20)->nullable();
            $table->string('Email2', 60)->nullable();
            $table->string('Web', 100)->nullable();
            $table->string('CustomerVendor')->nullable();
            $table->integer('DnBRating')->nullable();
            $table->string('CustomerFreightPaidCode', 10)->nullable();
            $table->string('CustomerPriority', 5)->nullable();
            $table->string('Active', 5)->nullable();
            $table->string('CustomerCurrencyCode', 10)->nullable();
            $table->integer('CustomerType')->nullable();
            $table->string('EdiAccount', 100)->nullable();
            $table->string('Remitto')->nullable();
            $table->string('CreditHold', 5)->nullable();
            $table->string('BackOrder', 5)->nullable();
            $table->string('CustomerComments', 150)->nullable();
            $table->integer('CostOfTerms')->nullable();
            $table->string('PrintStatementOfAccount', 10)->nullable();
            $table->string('PrintCustomerOnAging', 10)->nullable();
            $table->double('Commission1')->nullable();
            $table->double('Commission2')->nullable();
            $table->double('Commission3')->nullable();
            $table->string('MasterCustomer', 100)->nullable();
            $table->string('ExportedToAccounting', 10)->nullable();
            $table->string('RoutingDays')->nullable();
            $table->string('IsHouseAccount', 10)->nullable();
            $table->string('PreviousCustomer', 100)->nullable();
            $table->string('RoutingGuide', 100)->nullable();
            $table->string('EDIInfo', 100)->nullable();
            $table->string('CustomerServiceRep', 60)->nullable();
            $table->string('AccountingRep', 60)->nullable();
            $table->string('NetAging', 10)->nullable();
            $table->integer('CustomerSalesmanGroupID')->nullable();
            $table->string('EDI753Required', 10)->nullable();
            $table->string('LastDateUpdated', 20)->nullable();
            $table->string('PhoneInternational', 20)->nullable();
            $table->string('DepartmentRequiredOnOrder', 10)->nullable();
            $table->string('PackingRequiredFor753', 10)->nullable();
            $table->string('Label', 20)->nullable();
            $table->string('Hanger', 100)->nullable();
            $table->string('Banded', 100)->nullable();
            $table->string('PreSize', 50)->nullable();
            $table->string('PolyBag', 10)->nullable();
            $table->string('Tags', 15)->nullable();
            $table->string('CareLabelCode', 15)->nullable();
            $table->string('CountryOrigin', 40)->nullable();
            $table->string('Sizers', 50)->nullable();
            $table->string('Stickers', 100)->nullable();
            $table->string('FlatPack', 15)->nullable();
            $table->string('POAccessoryRemarks', 150)->nullable();
            $table->string('WashInstr', 100)->nullable();
            $table->string('PreTicket', 10)->nullable();
            $table->string('Stuff')->nullable();
            $table->string('CustomCode1', 15)->nullable();
            $table->string('CustomCode2', 15)->nullable();
            $table->string('CustomCode3', 15)->nullable();
            $table->string('CustomCode4', 15)->nullable();
            $table->string('CustomCode5', 15)->nullable();
            $table->string('CustomCode6', 15)->nullable();
            $table->string('CustomCode7', 15)->nullable();
            $table->string('CustomCode8', 15)->nullable();
            $table->string('CustomCode9', 15)->nullable();
            $table->string('CustomCode10', 15)->nullable();
            $table->integer('RNNumber')->nullable();
            $table->string('SeasonCode', 50)->nullable();
            $table->string('PRINTNumber', 100)->nullable();
            $table->string('SLEEVETYPE', 100)->nullable();
            $table->string('NECKLINE/COLLAR', 50)->nullable();
            $table->string('SubGroupCode', 20)->nullable();
            $table->string('MasterGroupCode', 30)->nullable();
            $table->string('MasterItem', 25)->nullable();
            $table->string('PACK', 70)->nullable();
            $table->string('Description', 200)->nullable();
            $table->string('CategoryCode', 30)->nullable();
            $table->string('Category1', 15)->nullable();
            $table->string('Gender', 10)->nullable();
            $table->string('ClassCode', 40)->nullable();
            $table->string('GroupCode', 20)->nullable();
            $table->string('PatternNumber', 50)->nullable();
            $table->string('CartonScaleCode', 20)->nullable();
            $table->integer('MasterUpcNumber')->nullable();
            $table->string('VendorCode', 40)->nullable();
            $table->integer('DesignNumber')->nullable();
            $table->string('BrandCode', 15)->nullable();
            $table->string('Caption', 255)->nullable();
            $table->string('WebItem', 5)->nullable();
            $table->string('FABRICCONTENTPRIMARY', 20)->nullable();
            $table->string('SLEEVELENGTH', 10)->nullable();
            $table->string('FlagCode', 30)->nullable();
            $table->string('FABRIC3', 60)->nullable();
            $table->string('TRIM', 50)->nullable();
            $table->string('Options', 50)->nullable();
            $table->integer('GLGroup')->nullable();
            $table->string('SafetyCode', 50)->nullable();
            $table->string('VendorItemNumber', 60)->nullable();
            $table->string('UPCNumber', 60)->nullable();
            $table->string('RoyaltyCode', 40)->nullable();
            $table->integer('QtyOrdered')->nullable();
            $table->integer('QtyAllocated')->nullable();
            $table->integer('QtyInvoiced')->nullable();
            $table->integer('OpenOrderQty')->nullable();
            $table->string('AllocatedValue', 100)->nullable();
            $table->string('InvoicedValue')->nullable();
            $table->double('OpenOrderValue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('openorder_import_temps');
    }
}
