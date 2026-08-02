<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogFaccoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_faccoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('apenado_id');
            $table->integer('integrante_id');
            $table->date('dataalteracao');

            $table->string('tipoalteracao');

            $table->string('faccaoDE');
            $table->string('faccaoPARA');
            $table->string('cargoDE');
            $table->string('cargoPARA');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_faccoes');
    }
}
