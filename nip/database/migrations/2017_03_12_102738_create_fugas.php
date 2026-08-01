<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFugas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fugas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo'); //FUGA - EVASÃO - QUEBRA
            $table->string('descricaofuga');
            $table->date('datafuga');
            $table->date('datarecaptura')->nullable();
            $table->string('descricaorecaptura')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('apenado_id')->unsigned();
            $table->integer('processo_id')->unsigned();
            $table->integer('movimentacao_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('processo_id')->references('id')->on('processos')->onDelete('cascade');
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes')->onDelete('cascade');

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
        Schema::dropIfExists('fugas');
    }
}
