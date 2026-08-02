<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppMenuTable extends Migration {


	public function up()
	{
		Schema::create('app_menu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',50);
			$table->string('icon',30);
			$table->integer('order');
			$table->integer('app_role_id')->unsigned();

            $table->dateTime('created_at');
            $table->dateTime('updated_at');

			$table->foreign('app_role_id')->references('id')->on('app_role');

		});
	}

	public function down()
	{
		Schema::drop('app_menu');
	}

}
