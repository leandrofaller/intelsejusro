<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numeropad');
            $table->string('descricaopad', 2000);
            $table->date('datainiciopad');
            $table->date('dataconclusaopad')->nullable();
            $table->string('situacaopad', 50)->nullable();

            $table->string('tipofato', 50);
            $table->string('tipofalta', 50);
            $table->string('numerorelatorioseguranca', 150);

            //relacionamentos
            $table->integer('apenado_id')->unsigned();
            $table->integer('processo_id')->unsigned();
            $table->integer('movimentacao_id')->unsigned();
            $table->integer('unidade_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            //CHAVE ESTRANGEIRA
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('processo_id')->references('id')->on('processos')->onDelete('cascade');
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pad');

    }
}
