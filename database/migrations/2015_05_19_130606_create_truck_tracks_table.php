<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('truck_tracks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('truck_id');
            $table->foreign('truck_id')
                ->references('id')->on('trucks') 
                ->onDelete('cascade');
            $table->string('lat');
            $table->string('long');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('truck_tracks');
	}

}
