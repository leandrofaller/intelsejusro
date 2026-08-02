<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {

            $table->increments('id');
            $table->string('nomeunidade');
            $table->string('siglaunidade');
            $table->string('cidadeunidade');
            $table->string('cnpj');
            $table->string('endereco');
            $table->string('categoria');
            $table->string('capacidade');
            $table->string('tipoestabelecimento');
            $table->string('nomediretorgeral');
            $table->string('nomediretoradm');
            $table->string('nomediretorseg');
            $table->string('telefoneunidade');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('recebeapenados');
            $table->string('obs');
            $table->string('tipo');
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
        Schema::dropIfExists('unidades');
    }
}
