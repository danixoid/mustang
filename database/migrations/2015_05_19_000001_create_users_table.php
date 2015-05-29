<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->boolean('is_admin')->default(0);
            $table->string('name');
            $table->string('surname');
            $table->string('father')->nullable();
			$table->string('email')->unique();
			$table->string('password', 60);
            $table->unsignedInteger('file_id')->nullable();
            $table->foreign('file_id')              //Файл картинка
                ->references('id')->on('files');
            $table->unsignedInteger('country_id')->nullable();
            $table->foreign('country_id')               //гражданство
                ->references('id')->on('countries');
            $table->boolean('resident')->default(0);
            $table->unsignedInteger('legal_id')->nullable();
            $table->foreign('legal_id')                 //страна регистрации автомобиля
                ->references('id')->on('legals');
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
