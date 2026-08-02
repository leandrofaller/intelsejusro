<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogClassificacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_classificacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('integrante_id');

            $table->integer('faccao_possiveis_id')->unsigned();
            $table->integer('faccao_classificacao_id')->unsigned();

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
        Schema::dropIfExists('log_classificacoes');
    }
}
