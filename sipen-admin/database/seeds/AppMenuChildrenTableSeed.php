<?php

use App\Models\Admin\App;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppMenu;
use App\Models\Admin\AppMenuChildren;
use App\Models\Admin\AppAction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppMenuChildrenTableSeed extends Seeder
{

    public function run()
    {
        DB::table('app_menu_children')->delete();


        $app = App::whereName('Admin')->first();
        $app_role_id = AppRole::whereAppId($app->id)->whereName('Administrador')->first()->id;

        $action_app = AppAction::whereRoute('sistemas.index')->first()->id;
        $action_roles = AppAction::whereRoute('papeis.index')->first()->id;
        $action_menus = AppAction::whereRoute('menus.index')->first()->id;
        $action_users = AppAction::whereRoute('usuarios.index')->first()->id;
        $action_acoes = AppAction::whereRoute('acoes.index')->first()->id;

        $menus = AppMenu::all();

        $menus_children = '';
        foreach ($menus as $menu)
        {
              switch($menu->title)
              {
                  case 'Sistemas':
                      $menus_children = ['title' => 'Listar', 'icon' => 'globe', 'order' => 1, 'app_menu_id' => $menu->id, 'app_action_id' => $action_app, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
                      break;

                  case 'Papéis':
                      $menus_children = ['title' => 'Listar', 'icon' => 'puzzle-piece', 'order' => 1, 'app_menu_id' => $menu->id, 'app_action_id' => $action_roles, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
                      break;

                  case 'Ações':
                      $menus_children = ['title' => 'Listar', 'icon' => 'list', 'order' => 1, 'app_menu_id' => $menu->id, 'app_action_id' => $action_acoes, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
                      break;

                  case 'Menus':
                      $menus_children = ['title' => 'Listar', 'icon' => 'list', 'order' => 1, 'app_menu_id' => $menu->id, 'app_action_id' => $action_menus, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
                      break;

                  case 'Usuários':
                      $menus_children =  ['title' => 'Listar', 'icon' => 'users', 'order' => 1, 'app_menu_id' => $menu->id, 'app_action_id' => $action_users, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')];
                      break;
                  default:
                      return;
                      break;


              }
            DB::table('app_menu_children')->insert($menus_children);

        }

    }
}
