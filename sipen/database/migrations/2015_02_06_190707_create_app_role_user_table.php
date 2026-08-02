<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppRoleUserTable extends Migration {

	public function up()
	{
		Schema::create('app_role_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('app_role_id')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('app_role_id')->references('id')->on('app_role');
		});
	}

	public function down()
	{
		Schema::drop('app_role_user');
	}

}
