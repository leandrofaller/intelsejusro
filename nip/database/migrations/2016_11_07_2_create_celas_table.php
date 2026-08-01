<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomecela');
            $table->string('tipocela');
            $table->string('capacidade');
            $table->string('status');
            //chaves estrangeiras
            $table->integer('carceragem_id')->unsigned();
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
        Schema::dropIfExists('celas');
    }
}
