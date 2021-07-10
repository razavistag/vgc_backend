<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->text('company')->nullable();
            $table->text('address')->nullable();
            $table->text('nic')->nullable();
            $table->text('gender')->nullable();
            $table->text('profilePic')->nullable();
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->integer('attempts')->nullable();
            $table->integer('google_id')->nullable();
            $table->integer('facebook_id')->nullable();
            $table->integer('twitter_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('role')->nullable();
            $table->json('access')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('dob')->nullable();
            $table->integer('language')->nullable();
            $table->integer('city')->nullable();
            $table->integer('location')->nullable();
            $table->integer('zip')->nullable();
            $table->integer('account_number')->nullable();
            $table->integer('user_type')->nullable(); // CUSTOMER  OR VENDOR OR SUPPLIER
            $table->integer('opening_balance')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('credit_limit')->nullable();
            $table->integer('payment_terms')->nullable(); // ?
            $table->integer('sales_rep_id')->nullable(); // ?
            $table->integer('basic_salary')->nullable();
            $table->integer('monthly_target')->nullable();
            $table->integer('target_percentage')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
