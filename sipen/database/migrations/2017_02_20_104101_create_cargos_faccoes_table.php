<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosFaccoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos_faccoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomecargo');
            $table->string('descricao');
            $table->string('nivel');
            $table->integer('faccao_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('faccao_id')->references('id')->on('faccoes')->onDelete('cascade');

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
        Schema::dropIfExists('cargos_faccoes');
    }
}
