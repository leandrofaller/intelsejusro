<?php

use App\Models\Users;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppRoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppRoleUserTableSeeder extends Seeder
{
  public function run()
  {
    $user  = Users::whereNome('Admin')->orWhere('email', '=', 'admin@admin.com')->first();
    $role = AppRole::whereName('Administrador')->first();


        $create =[    [
                'app_role_id' => $role->id,
                'user_id'     => $user->id,
                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]];
      DB::table('app_role_user')->insert($create);

  }
}