<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country;
use App\Models\User;
use App\Models\TruckType;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        
        //$this->call('CountryTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('TruckTypeTableSeeder');
        
        
		// $this->call('UserTableSeeder');
	}

}

class CountryTableSeeder extends Seeder {
    
    public function run()
	{
        DB::table('countries')->delete();
        
        Country::create(array(
            'country_name'  => 'Республика Казахстан',
            'short_name'    => 'Казахстан',
            'country_code'  => 'KZ',
        ));
        
        Country::create(array(
            'country_name'  => 'Российская Федерация',
            'short_name'    => 'Россия',
            'country_code'  => 'RU',
        ));
    }
}

class UserTableSeeder extends Seeder {
    
    public function run()
	{
        DB::table('users')->delete();
        
        User::create(array(
            'is_admin'  => TRUE,
            'phone'     => '+77774260576',
            'name'      => 'Данияр',
            'surname'   => 'Саумбаев',
            'father'    => 'Карияевич',
            'email'     => 'danixoid@gmail.com',
            'password'  => Hash::make('Roamer'),
            'resident'  => TRUE,
        ));
	}
}



class TruckTypeTableSeeder extends Seeder {
    
    public function run()
	{
        DB::table('truck_types')->delete();
        
        TruckType::create(array(
            'code'  => 'EUROFURA',
            'description'  => 'Тентованный полуприцеп (еврофура)<br />'
                . 'Самый распространенный тип кузова. Пригоден для перевозки большинства грузов. '
                . 'Растентовка позволяет производить загрузку сверху и сбоку. '
                . 'Грузоподъемность: 20-25 тонн. <br />'
                . 'Полезный объем: 82-92 м.куб. Размеры: длинна 13,6м, '
                . 'ширина 2,48м, высота 2,6-2,8м <br />'
                . 'Вместимость: 33-34 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'JUMBO',
            'description'  => '"Jumbo"<br />'
                . 'Полуприцеп большей вместимости. '
                . 'Это достигается за счет специального "Г"-образного пола '
                . 'и уменьшенного диаметра колес полуприцепа. '
                . 'Грузоподъемность: до 20 тонн. <br />'
                . 'Полезный объем: 96-105 м.куб <br />'
                . 'Вместимость: 33 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'AUTOSCEP',
            'description'  => '"Автосцепка"<br />'
                . 'Автомобиль с кузовом на одной раме + прицеп. '
                . 'Преимущество: быстрая погрузка (разгрузка) и большой полезный объем. '
                . 'Недостаток: не пригоден для перевозки длинномерных грузов. '
                . 'Грузоподъемность:16-25 тонн. <br />'
                . 'Полезный объем: 100-120 м.куб. Размеры кузова тягача и прицепа: '
                . 'длинна от 6 до 9м, ширина 2,48м,высота от 2,6 до 3,2м<br />'
                . 'Вместимость: 33-44 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'PAROVOZ',
            'description'  => 'Автосцепка-Паровоз<br />',
        ));
        
        TruckType::create(array(
            'code'  => '',
            'description'  => ' <br />'.
                'Полуприцеп большей вместимости. Это достигается за счет специального "Г"-образного пола '
                . 'и уменьшенного диаметра колес полуприцепа. Грузоподъемность: до 20 тонн. <br />'
                . 'Полезный объем: 96-105 м.куб <br />'
                . 'Вместимость: 33 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'REFRFURG',
            'description'  => 'Рефрижераторный фургон<br />'
                . 'Полуприцеп-холодильник. Пригоден для перевозки большинства видов '
                . 'скоропортящихся продуктов и грузов со спец. условиями хранения: '
                . 'от +25`С до - 25`С. В эксплуатации дороже на 5-25%. <br />'
                . 'Грузоподъемность: 12-22 тонн.<br />'
                . 'Полезный объем: 60-92 м.куб.'
                . 'Вместимость: 24-33 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'IZOTFURG',
            'description'  => 'Изотермический фургон<br />'
                . 'Предназначен для перевозки продуктов питания. Может удерживать '
                . 'определенную температуру длительное время. Бывает полуприцеп, автосцепка и одиночный. '
                . 'Грузоподъемность: 3-25 тонн.<br />'
                . 'Полезный объем: 32-92 м.куб.'
                . 'Вместимость: 6-33 европаллета.',
        ));
        
        TruckType::create(array(
            'code'  => 'CONTVOZ',
            'description'  => 'Контейнеровоз<br />'
                . 'Контейнерная площадка.',
        ));
        
        TruckType::create(array(
            'code'  => 'OPBORTPP',
            'description'  => 'Открытый бортовой полуприцеп<br />'
                . 'Применяется для перевозки грузов, устойчивых к внешним '
                . 'погодным воздействиям. Грузоподъемность: 3-25 тонн.<br />',
        ));
        
        TruckType::create(array(
            'code'  => 'OPENPLAT',
            'description'  => 'Открытая платформа<br />'
                . 'Применяется для перевозки грузов, устойчивых к внешним погодным воздействиям. '
                . 'Может также использоваться для перевозки негабаритного оборудования. '
                . 'Грузоподъемность: 15-20 тонн',
        ));
        
        TruckType::create(array(
            'code'  => 'AUTOVOZ',
            'description'  => 'Автовоз',
        ));
        
        TruckType::create(array(
            'code'  => 'BIGPLAT',
            'description'  => 'Платформа для негабаритных и тяжеловесных грузов<br />'
                . 'Применяется для перевозки негабаритных и тяжеловестных грузов. '
                . 'Грузоподъемность: 20-200 тонн',
        ));
        
        TruckType::create(array(
            'code'  => 'SPECTRAL',
            'description'  => 'Трал для перевозки спецтехники',
        ));
        
        TruckType::create(array(
            'code'  => 'CISTERNA',
            'description'  => 'Автоцистерна<br />'
                . 'Применяется для перевозки пищевых и непищевых наливных грузов. '
                . 'Грузоподъемность: 12-30 тонн<br />'
                . 'Полезный объем: 6-40 м.куб.',
        ));
        
        TruckType::create(array(
            'code'  => 'LESOVOZ',
            'description'  => 'Автоцистерна<br />'
                . 'Предназначен для перевозки лесной продукции и продукции лесопиления. '
                . 'Позволяет загружать также изделия металлопроката.<br />'
                . 'Грузоподъемность: 10-20 тонн',
        ));
        
        TruckType::create(array(
            'code'  => 'SORTIVOZ',
            'description'  => 'Сортиментовоз',
        ));
        
        TruckType::create(array(
            'code'  => 'BABOCHKA',
            'description'  => 'Фургон "Бабочка"',
        ));
    }
}