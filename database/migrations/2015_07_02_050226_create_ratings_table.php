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
            $table->unsignedInteger('transporter_id');
            $table->tinyInteger('votes')->default(0);
            $table->text('details');
            $table->softDeletes();
			$table->timestamps();

            $table->foreign('transporter_id')
                ->references('id')->on('transporters');
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
