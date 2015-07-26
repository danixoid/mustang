<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->float('debit')->default(0);
            $table->float('credit')->default(0);
            $table->string('description')->nullable();
            $table->morphs('taggable');
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
		Schema::drop('billings');
	}

}
