<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApenadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apenados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomeapenado');
            $table->string('rg');
            $table->string('cpf');
            $table->date('datanascimento');
            $table->string('nomepai');
            $table->string('nomemae');
            $table->string('sexo');
            $table->string('etnia');
            $table->string('naturalidade');
            $table->string('escolaridade');
            $table->date('datacadastro');

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
        Schema::dropIfExists('apenados');
    }
}
