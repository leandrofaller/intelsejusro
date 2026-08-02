<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Galerias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galerias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 200);
            $table->text('descricao');
            $table->string('imagem', 200);

            $table->string('publico', 5);

            $table->integer('fk_categoria')->unsigned();
            $table->foreign('fk_categoria')->references('id')->on('galeriaCategoria')->onDelete('cascade');

            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('galerias');
    }
}
