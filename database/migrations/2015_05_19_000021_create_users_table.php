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
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('father')->nullable();
			$table->string('email')->unique();
			$table->string('password', 60);
            $table->unsignedInteger('truck_id')->nullable();
            $table->unsignedInteger('file_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('legal_id')->nullable();
            $table->boolean('resident')->default(0);
            $table->boolean('activated')->default(0);
            $table->rememberToken();
			$table->timestamps();

            $table->foreign('truck_id')                 //Грузовик
                ->references('id')->on('trucks');
            $table->foreign('file_id')                  //Файл картинка
                ->references('id')->on('files');
            $table->foreign('country_id')               //гражданство
                ->references('id')->on('countries');
            $table->foreign('legal_id')                 //страна регистрации автомобиля
                ->references('id')->on('legals');
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
