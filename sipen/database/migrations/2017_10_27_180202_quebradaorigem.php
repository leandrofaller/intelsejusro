<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Quebradaorigem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quebradaorigem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nome_origem')->unsigned();
            $table->string('atual_origem');

            //relacionamentos
            $table->integer('integrante_id')->unsigned();
            $table->integer('apenado_id')->unsigned();
            $table->integer('user_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('integrante_id')->references('id')->on('integrantes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');

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
        Schema::dropIfExists('quebradaorigem');
    }
}
