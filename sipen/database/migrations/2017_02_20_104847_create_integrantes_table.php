<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('databatismo');

            $table->date('datasaida');
            $table->string('motivosaidafaccao');

            $table->integer('apenado_id')->unsigned();
            $table->integer('faccao_id')->unsigned();

            $table->integer('faccao_possiveis_id')->unsigned();
            $table->integer('faccao_classificacao_id')->unsigned();


            //CHAVE ESTRANGEIRA
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('faccao_id')->references('id')->on('faccoes')->onDelete('cascade');

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
        Schema::dropIfExists('integrantes');
    }
}
