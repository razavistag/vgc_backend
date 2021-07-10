<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivinglogenteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivinglogenteries', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->integer('division')->nullable();
            $table->integer('vendor')->nullable();
            $table->string('amt_shipment', 100)->nullable();
            $table->string('container', 100)->nullable();
            $table->text('po')->nullable();
            $table->text('etd_date')->nullable();
            $table->text('eta_date')->nullable();
            $table->text('est_eta_war_date')->nullable();
            $table->text('actual_eta_war_date')->nullable();
            $table->text('tally_date')->nullable();
            $table->text('sys_rec_date')->nullable();
            $table->string('appointment_no', 100)->nullable();
            $table->string('trucker', 100)->nullable();
            $table->string('carton', 100)->nullable();
            $table->string('pcs', 100)->nullable();
            $table->float('wh_charge')->nullable();
            $table->text('miss')->nullable();
            $table->text('current_note')->nullable();
            $table->text('status_note')->nullable();
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
        Schema::dropIfExists('receivinglogenteries');
    }
}
