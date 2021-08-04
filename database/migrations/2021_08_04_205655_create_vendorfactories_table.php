<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorfactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendorfactories', function (Blueprint $table) {
            $table->id();
            $table->string('factory_name')->nullable();
            $table->string('factory_code')->nullable();
            $table->string('factory_mobile')->nullable();
            $table->string('factory_email')->nullable();
            $table->string('factory_address')->nullable();
            $table->string('vendor_name')->nullable();
            $table->integer('vendor_auto_id');
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
        Schema::dropIfExists('vendorfactories');
    }
}
