<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevelopmentErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('development_errors', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->text('current_url');
            $table->text('full_url');
            $table->text('ip');
            $table->text('user_agent');
            $table->text('message');
            $table->text('function');
            $table->string('status');   //status can be use to track the current state of the log 0 is equal to issue exisist yet
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
        Schema::dropIfExists('development_errors');
    }
}
