<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Enderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rua_endereco');
            $table->string('numero_endereco', 10);
            $table->string('complemento_endereco');
            $table->string('bairro_endereco');

            $table->string('uf_endereco');
            $table->string('cidade_endereco');

            //relacionamentos
            $table->integer('apenado_id')->unsigned();
            $table->integer('user_id')->unsigned();

            //CHAVE ESTRANGEIRA
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
        Schema::dropIfExists('enderecos');

    }
}
