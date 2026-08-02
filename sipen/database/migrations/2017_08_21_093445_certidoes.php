<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Certidoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigoapenado');
            $table->string('nome');
            $table->string('foto');
            $table->string('execucao');
            $table->string('pai');
            $table->string('mae');
            $table->date('nascimento');
            $table->string('endereco');
            $table->string('naturalidade');
            $table->string('cpf');
            $table->string('rg');
            $table->string('regime');
            $table->date('dataentrada');
            $table->date('datasaida');
            $table->string('comportamento');
            $table->string('solicitante');
            $table->string('chavevalidacao');
            $table->integer('unidade_id');
            $table->integer('user_id');
            $table->string('tipocertidao');
            $table->string('relatorios');
            $table->string('texto');
            $table->string('comarca');
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
