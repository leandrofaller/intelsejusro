<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class AppTableSeeder extends Seeder
{


    public function run()
	{
        DB::table('app')->delete();

        $app = [[
            'name' => 'Admin',
            'url'  => 'http://dev.admin.com',
            'active' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],
            [
                'name' => 'Hospedagem',
                'url'  => 'http://dev.hospedagem.com',
                'active' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]];

        DB::table('app')->insert($app);


	}
}