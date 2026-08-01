<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Temporarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('motivo');
            $table->string('descricao', 1000);
            $table->date('datasaida');
            $table->date('dataretorno')->nullable();
            $table->string('descricaoretorno', 1000);
            $table->string('documento', 100);

            $table->string('escolta', 20);
            $table->string('horasaida', 5);
            $table->string('horaretorno', 5)->nullable();

            //relacionamentos
            $table->integer('apenado_id')->unsigned();
            $table->integer('processo_id')->unsigned();
            $table->integer('movimentacao_id')->unsigned();
            $table->integer('unidade_id')->unsigned();
            $table->integer('user_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('processo_id')->references('id')->on('processos')->onDelete('cascade');
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

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
        Schema::dropIfExists('certidoes');

    }
}
