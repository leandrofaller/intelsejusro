<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alcunhas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcunhas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_alcunha');
            $table->string('atual_alcunha', 1);

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
        Schema::dropIfExists('alcunhas');

    }
}
