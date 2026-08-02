<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            'nomeunidade' => 'PENITENCIÁRIA EDVAN MARIANO ROSENDO',
            'siglaunidade' => 'PEMR',
            'cidadeunidade' => 'PORTO VELHO',
            'categoria' => 'Masculino',
            'capacidade' => '350',
            'tipoestabelecimento' => 'Penitenciária',
            'nomediretorgeral' => 'NOME DO DIRETOR',
            'nomediretoradm' => 'NOME DO DIRETOR',
            'nomediretorseg' => 'NOME DO DIRETOR',
            'telefoneunidade' => 'NOME DO DIRETOR',
        ]);

        DB::table('unidades')->insert([
            'nomeunidade' => 'INFOPEN',
            'siglaunidade' => 'PEMR',
            'cidadeunidade' => 'PORTO VELHO',
            'capacidade' => '0',
            'categoria' => 'Infopen',
            'tipoestabelecimento' => 'Infopen',
            'nomediretorgeral' => 'NOME DO DIRETOR',
            'nomediretoradm' => 'NOME DO DIRETOR',
            'nomediretorseg' => 'NOME DO DIRETOR',
            'telefoneunidade' => 'NOME DO DIRETOR',
        ]);

    }
}
