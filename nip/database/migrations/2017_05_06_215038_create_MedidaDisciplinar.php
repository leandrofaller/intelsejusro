<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidaDisciplinar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('medidadisciplinar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipomedida_md');
            $table->string('unidades_md'); //campo utilizado também para justificativas do tipo de medida.
            $table->date('datainicio_md');
            $table->string('tempo_md');

            $table->date('datafim_md')->nullable();
            $table->string('descricao_md', 1500)->nullable();
            $table->string('descricaobaixa_md', 1500)->nullable();
            $table->string('ocorrencia_md', 100);
            $table->string('plantao_md');
            $table->date('databaixa_md')->nullable();

            //relacionamentos
            $table->integer('apenado_id')->unsigned();
            $table->integer('processo_id')->unsigned();
            $table->integer('movimentacao_id')->unsigned();
            $table->integer('unidade_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            //CHAVE ESTRANGEIRA
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');
            $table->foreign('processo_id')->references('id')->on('processos')->onDelete('cascade');
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medidadisciplinar');

    }
}
