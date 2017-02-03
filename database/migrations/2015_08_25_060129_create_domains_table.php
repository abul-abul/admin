<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('sub_domain')->unique();
            $table->string('css');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('favicon');
            $table->string('ticket_title');
            $table->string('fan_title');
            $table->string('language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('domains');
    }
}
