<?php

use App\Models\Admin\App;
use App\Models\Admin\AppRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppRoleTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('app_role')->delete();

    $admin = App::whereName('Admin')->first()->id;

    $roles = [[
    	'name'   => 'Administrador',
    	'app_id' => $admin,
    	'active' => 1,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ]];
      DB::table('app_role')->insert($roles);
  }
}