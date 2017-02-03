<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests_questions', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->integer('contest_id');
            $table->string('language');
            $table->string('question');
            $table->boolean('mandatory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contests_questions');
    }
}
