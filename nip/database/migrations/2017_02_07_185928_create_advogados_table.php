<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvogadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advogados', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nomeadvogado');
            $table->string('rgadvogado');
            $table->string('cpfadvogado');
            $table->string('oab');
            $table->string('enderecoadvogado');
            $table->string('seccional');
            $table->string('telefoneadvogado');
            $table->string('escolaridade');
            $table->string('foto');
            $table->date('datacadastroadvogado');

            $table->timestamps();
        });

        Schema::create('advogados_apenados', function($table)
        {
            $table->increments('id');
            $table->date('datacadastro');
            $table->integer('user_id');
            $table->date('datacancelamento')->nullable();
            $table->string('motivo')->nullable();


            $table->integer('apenado_id')->unsigned();
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');

            $table->integer('advogado_id')->unsigned();
            $table->foreign('advogado_id')->references('id')->on('advogados')->onDelete('cascade');

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
        Schema::dropIfExists('advogados');
    }
}
