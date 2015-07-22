<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tracked_id');
            $table->tinyInteger('votes')->default(0);
            $table->text('details');
            $table->softDeletes();
            $table->timestamps();

            //$table->index(["user_id", "tracked_id"]);
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
		Schema::drop('ratings');
	}

}
