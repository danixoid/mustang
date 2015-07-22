<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trucks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->unsignedInteger('truck_type_id');
            $table->unsignedInteger('file_id')->nullable();
            $table->string('gos_number',16);        //гос.номер авто
            $table->string('brand',32);             //марка автомобиля
            $table->string('seria',16)->nullable(); //серия марки автомобиля
            $table->float('volume')->default(0);    //ёмкость в метрах кубических
            $table->float('width')->default(0);     //ширина в метрах
            $table->float('height')->default(0);    //высота в метрах
            $table->float('length')->default(0);    //длина в метрах
            $table->float('capacity')->default(0);  //грузоподъемность в тоннах
            $table->timestamps();                   //время создания записи и обновления

            $table->foreign('country_id')           //страна регистрации автомобиля
                ->references('id')->on('countries');
            $table->foreign('status_id')            //статус авто
                ->references('id')->on('statuses');
            $table->foreign('truck_type_id')        //гражданство
                ->references('id')->on('truck_types');
            $table->foreign('file_id')              //Файл картинка
                ->references('id')->on('files');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trucks');
	}

}
