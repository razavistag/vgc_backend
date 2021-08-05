<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_auto_id')->nullable();
            $table->string('vendor', '100')->nullable();
            $table->string('vendor_email', '100')->nullable();
            $table->string('vendor_code', '10')->nullable();

            $table->integer('factory_auto_id')->nullable();

            $table->integer('agent_auto_id')->nullable();
            $table->string('agent', '100')->nullable();
            $table->string('agent_email', '100')->nullable();
            $table->string('agent_code', '10')->nullable();

            $table->text('po_date')->nullable();
            $table->string('po_number', '25')->nullable();

            $table->string('style', '25')->nullable();
            $table->string('priority', '10')->nullable();
            $table->tinyInteger('status')->nullable();

            $table->string('cus_po_number', '25')->nullable();
            $table->integer('customer_auto_id')->nullable();
            $table->string('customer', '100')->nullable();
            $table->string('customer_email', '100')->nullable();

            $table->integer('receiver_auto_id')->nullable();
            $table->string('receiver', '100')->nullable();
            $table->string('receiver_email', '100')->nullable();

            $table->integer('company_auto_id')->nullable();
            $table->text('company')->nullable();

            $table->integer('number_of_style')->nullable();
            $table->integer('control_number')->nullable();
            $table->integer('qty')->nullable();
            $table->double('total_value')->nullable();
            $table->text('po_request_date')->nullable();
            $table->json('attachment_auto_id')->nullable();

            $table->string('beneficiary', '50')->nullable();
            $table->text('house_date')->nullable();
            $table->text('ex_fty_date')->nullable();
            $table->text('cancel_date')->nullable();
            $table->string('hanger', '50')->nullable();
            $table->decimal('hanger_cost', 11, 2)->nullable();
            $table->string('payment_term', '50')->nullable();
            $table->string('load_port', '50')->nullable();
            $table->string('port_of_entry', '50')->nullable();
            $table->string('ship_via', '50')->nullable();
            $table->string('cost_type', '50')->nullable();
            $table->string('warehouse', '100')->nullable();
            $table->string('instruction', '50')->nullable();

            // unfilled columns on PO Form
            $table->tinyInteger('season')->nullable();
            $table->string('po_subject', '25')->nullable();
            $table->string('completed_by', '100')->nullable();
            $table->string('completed_by_email', '100')->nullable();
            $table->string('approved_by', '100')->nullable();
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
        Schema::dropIfExists('pos');
    }
}
