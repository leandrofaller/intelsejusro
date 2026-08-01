<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTable extends Migration {


	public function up()
	{
		Schema::create('app', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',50);
			$table->string('url',100);
			$table->char('active',1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
		});
	}


	public function down()
	{
		Schema::drop('app');
	}

}
