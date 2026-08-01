<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('logger', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fkuser')->nullable();;
            $table->string('alert',1);
            $table->string('title',50);
            $table->text('message');
            $table->integer('app_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logger');

    }
}
