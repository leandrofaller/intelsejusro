<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstadoCivil extends Migration
{
    public function up()
    {
        Schema::create('estado_civil', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao',50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('estado_civil');
    }
}
