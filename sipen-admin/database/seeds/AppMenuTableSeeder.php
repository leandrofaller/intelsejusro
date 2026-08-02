<?php

use App\Models\Admin\App;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppMenu;
use App\Models\Admin\AppAction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppMenuTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('app_menu')->delete();

    $app         = App::whereName('Admin')->first();
    $app_role_id = AppRole::whereAppId($app->id)->whereName('Administrador')->first()->id;

    $menus = 
    [
      ['title' => 'Sistemas', 'icon' => 'globe',        'order' => 1, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
      ['title' => 'Papéis',   'icon' => 'puzzle-piece', 'order' => 2, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
      ['title' => 'Ações',    'icon' => 'bolt',         'order' => 3, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
      ['title' => 'Usuários', 'icon' => 'users',        'order' => 4, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
      ['title' => 'Menus',    'icon' => 'list',         'order' => 5, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
      ['title' => 'Logs',    'icon' => 'gears',         'order' => 6, 'app_role_id' => $app_role_id, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
    ];

      DB::table('app_menu')->insert($menus);

  }
}