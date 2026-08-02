<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CarceragemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carceragens')->insert([ 'nomecarceragem' => 'Carceragem 1', 'tipocarceragem' => 'Normal', 'status' => 'Ativo', 'unidade_id' => 1 ]);
        DB::table('carceragens')->insert([ 'nomecarceragem' => 'Carceragem 2', 'tipocarceragem' => 'Normal', 'status' => 'Ativo', 'unidade_id' => 1 ]);
        DB::table('carceragens')->insert([ 'nomecarceragem' => 'Carceragem 3', 'tipocarceragem' => 'Normal', 'status' => 'Ativo', 'unidade_id' => 1 ]);
        DB::table('carceragens')->insert([ 'nomecarceragem' => 'Pavilhão J', 'tipocarceragem' => 'Normal', 'status' => 'Ativo', 'unidade_id' => 1 ]);
        DB::table('carceragens')->insert([ 'nomecarceragem' => 'Pavilhão RDD', 'tipocarceragem' => 'Normal', 'status' => 'Ativo', 'unidade_id' => 1 ]);


    }
}
