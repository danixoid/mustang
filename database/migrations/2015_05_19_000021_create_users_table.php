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
            $table->unsignedInteger('track_id')->nullable();
            $table->unsignedInteger('picture_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('legal_id')->nullable();
            $table->boolean('resident')->default(FALSE);
            $table->rememberToken();
            $table->softDeletes();
			$table->timestamps();

            $table->index('truck_id');
            $table->foreign('truck_id')                 //Грузовик
                ->references('id')->on('trucks')
                ->onDelete('set null');
            $table->foreign('track_id')                 //Местоположение
                ->references('id')->on('tracks');
            $table->foreign('picture_id')               //Файл картинка
                ->references('id')->on('files')
                ->onDelete('set null');
            $table->foreign('country_id')               //гражданство
                ->references('id')->on('countries')
                ->onDelete('set null');
            $table->foreign('legal_id')                 //страна регистрации автомобиля
                ->references('id')->on('legals')
                ->onDelete('set null');
        });


        Schema::table('tracks', function($table)
        {
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('tracks', function($table)
        {
            $table->dropForeign('tracks_user_id_foreign');
        });

        Schema::drop('users');
	}

}
