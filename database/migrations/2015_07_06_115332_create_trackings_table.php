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
            $table->unsignedInteger('track_user_id');
            $table->unsignedInteger('status_id');
            $table->tinyInteger('votes')->default(0);
            $table->text('details');
            $table->timestamps();

            $table->index(["user_id", "track_user_id"]);
            $table->foreign('user_id')                  //Грузоотправитель
            ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('track_user_id')            //Грузоперевозчик
            ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('status_id')                //Статус
            ->references('id')->on('statuses')
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
