<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('cargo_id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('status_id')->nullable();
			$table->timestamps();

            $table->index(["cargo_id", "user_id"]);

            $table->foreign('cargo_id')
                ->references('id')->on('cargos')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')->on('statuses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transporters');
	}

}
