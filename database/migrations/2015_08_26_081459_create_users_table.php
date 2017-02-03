<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('hash');
            $table->string('active')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('language');
            $table->date('birthday');
            $table->string('gender');
            $table->string('street');
            $table->string('phone')->nullable();
            $table->string('po_box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('customer_value');
            $table->string('customer_type');
            $table->string('company_name')->nullable();
            $table->integer('function');
            $table->tinyInteger('newsletter')->default(1);
            $table->dateTime('creation_date');
            $table->dateTime('last_modified_date')->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->tinyInteger('corporate')->default(0);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
