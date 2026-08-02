<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class estados extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',50);
            $table->string('sigla',2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
}
