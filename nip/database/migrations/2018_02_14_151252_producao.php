<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Producao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producao', function (Blueprint $table) {
            $table->increments('id');
            $table->int('codigo');
            $table->string('ano');
            $table->string('seguranca');
            $table->string('numero');
            $table->date('datarelatorio');
            $table->string('assunto');
            $table->string('origem');
            $table->string('difusao');
            $table->string('difusaoanterior');
            $table->string('referencia');
            $table->string('anexo');
            $table->string('chave');

            $table->string('conteudo');
            $table->string('fechamento');

            //relacionamentos
            $table->integer('tipo_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('unidade_id')->unsigned();

            //CHAVE ESTRANGEIRA
            $table->foreign('tipo_id')->references('id')->on('producao_tipo')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('producao_status')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

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
        Schema::dropIfExists('producao');
    }
}
