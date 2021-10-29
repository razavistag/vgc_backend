<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentImportTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_import_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('Ref')->nullable();
            $table->integer('Po')->nullable();
            $table->string('Item', 50)->nullable();
            $table->string('ColorCode', 150)->nullable();
            $table->string('ColorDescription', 150)->nullable();
            $table->string('LC', 150)->nullable();
            $table->string('Customer', 150)->nullable();
            $table->string('qty', 150)->nullable();
            $table->integer('OfCrtns')->nullable();
            $table->string('PricePerPiece')->nullable();
            $table->string('Value')->nullable();
            $table->string('StandardCost')->nullable();
            $table->string('ExtendedStandardCost')->nullable();
            $table->string('DateEntered')->nullable();
            $table->string('DepartureDate')->nullable();
            $table->string('ArrivalDate')->nullable();
            $table->string('Shipvia')->nullable();
            $table->string('CarrierName')->nullable();
            $table->string('Cont')->nullable();
            $table->string('BOL')->nullable();
            $table->string('HAWB')->nullable();
            $table->string('MAWB')->nullable();
            $table->string('WHSE')->nullable();
            $table->string('RcvingNumber')->nullable();
            $table->string('PortOfEntry')->nullable();
            $table->string('ReceivedDate')->nullable();
            $table->string('QtyReceived')->nullable();
            $table->string('ValueReceived')->nullable();
            $table->string('ClearedCustomsDate')->nullable();
            $table->string('VendorName')->nullable();
            $table->string('Inv')->nullable();
            $table->string('InvoiceDate')->nullable();
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
        Schema::dropIfExists('shipment_import_temps');
    }
}
