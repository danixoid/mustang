<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('truck_statuses', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('code',16)->unique();
            $table->string('description',125)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('truck_statuses');
	}

}
