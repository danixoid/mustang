<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_relations', function(Blueprint $table)
		{
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('friend_user_id');
            $table->timestamps();

            $table->index(["user_id", "friend_user_id"]);
            $table->foreign('user_id')                  //пользователь
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('friend_user_id')           //пользователь
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
		Schema::drop('users_relations');
	}

}
