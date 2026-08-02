<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProducaoAnexo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producao_anexo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomeanexo');
            $table->string('status');

            //relacionamentos
            $table->integer('producao_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('producao_id')->references('id')->on('producao')->onDelete('cascade');

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
        Schema::dropIfExists('producao_anexo');

    }
}
