<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numeroprocesso');
            $table->string('vara');
            $table->string('tipificacao');
            $table->string('artigos');
            $table->date('datacondenacao')->nullable();
            $table->string('tempodepena')->nullable();
            $table->string('principal')->nullable();
            $table->date('dataprisao')->nullable();
            $table->date('databeneficio')->nullable();

            //relacionamentos
            $table->integer('apenado_id')->unsigned();

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
        Schema::dropIfExists('processos');
    }
}
