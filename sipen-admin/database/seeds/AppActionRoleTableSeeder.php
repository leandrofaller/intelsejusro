<?php 

use App\Models\Admin\App;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppAction;
use App\Models\Admin\AppActionRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppActionRoleTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('app_action_role')->delete();

		$apps = App::all();
		foreach ($apps as $app)
		{
			$actions  = AppAction::whereAppId($app->id)->get();
			$app_role = AppRole::whereName('Administrador')->whereAppId($app->id)->first();


            foreach($actions as $action)
            {
                DB::table('app_action_role')->insert(['app_action_id' => $action->id, 'app_role_id'   => $app_role->id,'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            }


		}
	}	
}