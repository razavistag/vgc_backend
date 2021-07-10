<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('order_date')->nullable();
            $table->text('cancel_date')->nullable();
            $table->text('comment')->nullable();
            $table->text('remark')->nullable();
            $table->text('eta')->nullable();
            $table->integer('production_auto_id')->nullable();
            $table->integer('customer_auto_id')->nullable();
            $table->string('customer', 100)->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->integer('sales_rep_auto_id')->nullable();
            $table->string('sales_rep', 100)->nullable();
            $table->string('sales_rep_email', 100)->nullable();
            $table->string('po_number', 25)->nullable();
            $table->string('or_style', 25)->nullable();
            $table->string('re_style', 25)->nullable();
            $table->string('factor_number', 25)->nullable();
            $table->string('receiver', 100)->nullable();
            $table->string('receiver_email', 100)->nullable();
            $table->string('completed_by', 100)->nullable();
            $table->string('completed_by_email', 100)->nullable();
            $table->string('completed_auto_id', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->string('approved_auto_by', 100)->nullable();
            $table->string('num_page', 15)->nullable();
            $table->string('production_by', 100)->nullable();
            $table->string('production_email', 100)->nullable();
            $table->text('company_auto_id')->nullable();
            $table->integer('control_number')->nullable();
            $table->integer('number_of_style')->nullable();
            $table->integer('receiver_auto_id')->nullable();
            $table->integer('status')->nullable();
            $table->tinyInteger('order_type')->nullable();
            $table->tinyInteger('is_immediate')->nullable();
            $table->tinyInteger('edi_status')->nullable();
            $table->tinyInteger('upc_status')->nullable();
            $table->tinyInteger('price_ticket')->nullable();
            $table->double('total_value')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
