<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('user_domains', function(Blueprint $table)
        {
            $table->increments('user_domain_id')->index();
            $table->integer('user_id');
            $table->integer('domain_id');
            $table->integer('user_domain_id_ixpole');
            $table->dateTime('creation_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('user_domains');
    }
}
