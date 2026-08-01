<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaccoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faccoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomefaccao');
            $table->string('sigla');
            $table->string('anofundacao');
            $table->string('origem');
            $table->string('historico');
            $table->string('cor');

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
        Schema::dropIfExists('faccoes');
    }
}
