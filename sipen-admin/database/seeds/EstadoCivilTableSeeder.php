<?php

use Illuminate\Database\Seeder;

class EstadoCivilTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('estado_civil')->delete();

        $estado_civil = [
            ['descricao' =>'Solteiro'],
            ['descricao' =>'Casado'],
            ['descricao' =>'Viúvo'],
            ['descricao' =>'Separado judicialmente'],
            ['descricao' =>'Divorciado'],
            ['descricao' =>'Outros'],
        ];

        DB::table('estado_civil')->insert($estado_civil);
    }
}
