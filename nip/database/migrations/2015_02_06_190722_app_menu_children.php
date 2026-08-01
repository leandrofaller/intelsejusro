<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppMenuChildren extends Migration
{

    public function up()
    {
        Schema::create('app_menu_children', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title',50);
            $table->string('icon',30);
            $table->integer('order');
            $table->integer('app_menu_id')->unsigned();
            $table->integer('app_action_id')->unsigned()->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('app_menu_id')->references('id')->on('app_menu');
            $table->foreign('app_action_id')->references('id')->on('app_action');
        });
    }

    public function down()
    {
        Schema::drop('app_menu_children');
    }
}
