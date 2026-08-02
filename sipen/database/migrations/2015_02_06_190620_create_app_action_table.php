<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppActionTable extends Migration {

	public function up()
	{
		Schema::create('app_action', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',50)->nullable();
			$table->string('route',50);
			$table->integer('app_id')->unsigned();
			$table->char('active',1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

			$table->foreign('app_id')->references('id')->on('app');
		});
	}


	public function down()
	{
		Schema::drop('app_action');
	}

}
