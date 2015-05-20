<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_accounts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')                  //пользователь
                ->references('id')->on('users') 
                ->onDelete('cascade');
            $table->unsignedInteger('account_id');      //аккаунт
            $table->foreign('account_id')
                ->references('id')->on('accounts') 
                ->onDelete('cascade');
            $table->timestamp('begin'); //->default('CURRENT_TIMESTAMP');
            $table->timestamp('end');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_accounts');
	}

}
