<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessSectionsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('acesso_faccionados')->default(true);
            $table->boolean('acesso_apenados')->default(true);
            $table->boolean('acesso_unidades')->default(true);
            $table->boolean('acesso_relatorios')->default(true);
            $table->boolean('acesso_producao')->default(true);
            $table->boolean('acesso_galeria')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'acesso_faccionados',
                'acesso_apenados',
                'acesso_unidades',
                'acesso_relatorios',
                'acesso_producao',
                'acesso_galeria'
            ]);
        });
    }
}
