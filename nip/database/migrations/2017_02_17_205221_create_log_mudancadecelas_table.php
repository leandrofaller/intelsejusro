<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogMudancadecelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_mudancadecelas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('apenado_id');
            $table->integer('unidade_id');
            $table->integer('processo_id');
            $table->integer('movimentacao_id');
            $table->date('datamudanca');
            $table->string('motivomudanca');
            $table->string('celaDE');
            $table->string('celaPARA');
            $table->string('descricao');
            $table->string('autorizadopor', 100)->nullable();
            $table->string('transferidopor', 100)->nullable();
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
        Schema::dropIfExists('log_mudancadecelas');
    }
}
