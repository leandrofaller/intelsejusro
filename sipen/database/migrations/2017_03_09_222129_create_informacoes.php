<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacoes extends Migration
{
    public function up()
    {
        Schema::create('informacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo'); //CADASTRO - FACCAO - UNIDADE
            $table->string('assunto');
            $table->string('descricaoinfo',1500);
            $table->date('datacadastro');
            $table->integer('user_id')->unsigned();
            $table->integer('apenado_id')->unsigned();
            $table->integer('unidade_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informacoes');
    }
}
