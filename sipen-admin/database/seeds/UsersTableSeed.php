<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeed extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        $user = [[
            'nome' => 'Admin',
            'cpf' => '12345678910',
            'email'  => 'admin@admin.com',
            'password'  => bcrypt('123'),
            
            'matricula' => '300116364',
            'perfil' => 'Admin',
            'unidade_id' => 1,
            
            'estado_civil_id'  => 1,
            'cidade_id'  => 3887,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]];

        DB::table('users')->insert($user);
    }
}
