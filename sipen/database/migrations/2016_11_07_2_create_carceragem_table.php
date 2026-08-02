<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarceragemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carceragens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomecarceragem');
            $table->string('tipocarceragem');
            $table->string('status');
            $table->string('faccoes');

            //chaves estrangeiras
            $table->integer('unidade_id')->unsigned();
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
        Schema::dropIfExists('carceragens');
    }
}
