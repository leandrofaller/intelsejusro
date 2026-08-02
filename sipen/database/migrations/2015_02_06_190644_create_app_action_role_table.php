<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppActionRoleTable extends Migration {

	public function up()
	{
		Schema::create('app_action_role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('app_role_id')->unsigned();
			$table->integer('app_action_id')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

			$table->foreign('app_role_id')->references('id')->on('app_role');
			$table->foreign('app_action_id')->references('id')->on('app_action');
		});
	}

	public function down()
	{
		Schema::drop('app_action_role');
	}

}
