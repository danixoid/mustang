<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('legals', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name',255)->unique();       //полное название физ/юр лица
            $table->string('director',125)->nullable(); //ФИО директора
            $table->string('email',64);
            $table->softDeletes();
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
		Schema::drop('legals');
	}

}
