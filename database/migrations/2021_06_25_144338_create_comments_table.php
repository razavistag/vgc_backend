<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->integer('document_status')->nullable();
            $table->text('comment')->nullable();
            $table->text('hrm_auto_id')->nullable();
            $table->text('current_time')->nullable();
            $table->json('email_add')->nullable();
            $table->string('hrm_name',50)->nullable();
            $table->tinyInteger('is_read')->nullable();
            $table->tinyInteger('is_send_email')->nullable();
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
        Schema::dropIfExists('comments');
    }
}
