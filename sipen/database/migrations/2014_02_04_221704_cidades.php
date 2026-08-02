<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class cidades extends Migration
{
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {

            $table->increments('id');
            $table->string('nome',150);
            $table->integer('codigo_ibge');
            $table->integer('estado_id')->unsigned();

            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cidades');
    }
}
