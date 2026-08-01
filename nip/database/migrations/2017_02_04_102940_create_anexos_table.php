<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('tipodocumento');
            $table->string('nomearquivo');
            $table->date('datalancamento');
            $table->integer('user_id');
            $table->integer('apenado_id');
            $table->integer('integrante_id');

            //relacionamentos
            $table->integer('processo_id')->unsigned();
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
        Schema::dropIfExists('anexos');
    }
}
