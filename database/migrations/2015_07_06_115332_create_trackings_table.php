<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trackings', function(Blueprint $table)
		{
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tracked_id');
            $table->timestamps();

            $table->index(["user_id", "tracked_id"]);
            $table->foreign('user_id')                  //Грузоотправитель
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('tracked_id')               //Грузоперевозчик
                ->references('id')->on('users')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trackings');
	}

}
