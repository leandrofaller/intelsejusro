<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomevisita');
            $table->string('cpfvisita');
            $table->string('rgvisita');
            $table->string('orgaoexpedicaovisita');

            $table->date('datanascimentovisita');
            $table->string('naturalidadevisita');

            $table->string('sexovisitante');
            $table->string('fotovisita');
            $table->string('enderecovisita');
            $table->string('ufvisita');
            $table->string('cidadevisita');
            $table->string('telefonecontato');
            $table->date('dataemicaocarteirinha');

            $table->timestamps();

        });

        Schema::create('visitas_apenados', function($table)
        {
            $table->increments('id');
            $table->date('datacadastro');
            $table->integer('user_id');
            $table->date('datacancelamento')->nullable();
            $table->string('motivo')->nullable();
            $table->string('parentescovisita');
            $table->integer('apenado_id')->unsigned();
            $table->foreign('apenado_id')->references('id')->on('apenados')->onDelete('cascade');

            $table->integer('visita_id')->unsigned();
            $table->foreign('visita_id')->references('id')->on('visitas')->onDelete('cascade');

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
        Schema::dropIfExists('visitas');
    }
}
