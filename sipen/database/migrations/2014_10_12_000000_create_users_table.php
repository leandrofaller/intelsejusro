<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('cpf',11)->unique();
            $table->string('matricula',20)->nullable();
            $table->string('rg',15)->nullable();
            $table->string('email',150)->unique();
            $table->string('password',150);
            $table->string('orgao_expedidor',10)->nullable();
            $table->char('sexo',1)->nullable();
            $table->integer('estado_civil_id')->unsigned();
            $table->date('dt_nascimento')->nullable();
            $table->string('nome_mae',100)->nullable();
            $table->string('nome_pai',100)->nullable();
            $table->string('rua',150)->nullable();
            $table->string('numero',5)->nullable();
            $table->string('complemento',100)->nullable();
            $table->string('bairro',100)->nullable();
            $table->integer('cidade_id')->unsigned();
            $table->string('cep',15)->nullable();
            $table->string('fone_fixo',15)->nullable();
            $table->string('celular',15)->nullable();
            $table->string('foto',200)->default('images/avatars/avatar2.png');
            $table->string('anexodocumento',200);
            $table->char('active',1)->default(1);
            
            //CRIADOS POR MARCOS MOREIRA
            $table->integer('unidade_id')->unsigned();
            $table->string('perfil');

            //chaves estrangeiras
            $table->foreign('estado_civil_id')->references('id')->on('estado_civil')->onDelete('cascade');;
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('cascade');;
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');;


            $table->rememberToken();
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
        Schema::drop('users');
    }
}
