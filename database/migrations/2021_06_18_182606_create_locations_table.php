<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name', 30)->nullable();
            $table->string('location_address', 150)->nullable();
            $table->string('location_city', 20)->nullable();
            $table->string('location_zip_code', 5)->nullable();
            $table->string('location_country', 2)->nullable();
            $table->string('location_phone', 15)->nullable();
            $table->tinyInteger('location_status')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
