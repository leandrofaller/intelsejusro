<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class CelaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('celas')->insert([ 'nomecela' => 'A/01','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/02','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/03','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/04','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/05','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/06','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);
        DB::table('celas')->insert([ 'nomecela' => 'A/07','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 1 ]);

        DB::table('celas')->insert([ 'nomecela' => 'D/01','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/02','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/03','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/04','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/05','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/06','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);
        DB::table('celas')->insert([ 'nomecela' => 'D/07','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 2 ]);

        DB::table('celas')->insert([ 'nomecela' => 'E/01','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/02','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/03','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/04','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/05','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/06','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);
        DB::table('celas')->insert([ 'nomecela' => 'E/07','tipocela' => 'Normal','status' => 'Ativo', 'carceragem_id' => 3 ]);

    }
}
