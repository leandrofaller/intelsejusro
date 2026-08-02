<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('regime');
            $table->date('dataentrada');
            $table->string('oficioentrada');
            $table->integer('unidadeorigem')->nullable();
            $table->string('presooriundo');
            $table->string('situacao');
            $table->string('monitorado');
            $table->date('datasaida')->nullable();
            $table->string('oficiosaida')->nullable();
            $table->string('motivosaida')->nullable();
            $table->integer('unidadedestino')->nullable();
            $table->integer('classificacao_id')->nullable();

            $table->string('oficiosaida')->nullable();
            $table->string('oficiosaida')->nullable();
            $table->string('oficiosaida')->nullable();

            $table->date('triagem_baixa');
            $table->date('triagem_inicio');
            $table->date('triagem_fim');

            $table->timestamps();

            $table->foreign('processo_id')->references('id')->on('processos')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->foreign('cela_id')->references('id')->on('celas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimentacoes');
    }
}
