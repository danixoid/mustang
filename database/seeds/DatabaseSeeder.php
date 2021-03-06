<?php

use App\Models\Account;
use App\Models\Rating;
use App\Models\Track;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country;
use App\Models\User;
use App\Models\TruckType;
use App\Models\Truck;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call('DBTableSeeder');
	}

}



class DBTableSeeder extends Seeder {

    public $cnt = 50;   //количество пользователей
    /**
     *
     */
    public function run()
    {
        User::whereNotNull('id')->update(array('truck_id' => null,'track_id' => null));
        DB::table('tracks')->delete();
        DB::table('trucks')->delete();
        DB::table('users')->delete();
        DB::table('countries')->delete();
        DB::table('truck_types')->delete();
        DB::table('accounts')->delete();
        DB::table('statuses')->delete();

        /*
         *              АККАУНТЫ ПОЛЬЗОВАТЕЛЕЙ
         */

        $account_id = Account::create(array(
            'code' => 'BASE_ACC',
            'days' => 30
        ))->id;

        Account::create(array(
            'code' => 'PREMIUM_ACC',
            'days' => 30
        ));


        /*
         *              СТАТУСЫ ГРУЗОВИКОВ
         */

        $truck_status = Status::create(array(
            'code' => 'TRUCK_FREE',
            'description' => 'Свободен'
        ));

        Status::create(array(
            'code' => 'TRUCK_LOADING',
            'description' => 'Загружается'
        ));

        Status::create(array(
            'code' => 'TRUCK_LOADED',
            'description' => 'Загружен'
        ));

        Status::create(array(
            'code' => 'TRUCK_SOS',
            'description' => 'Нужна помощь!'
        ));

        Status::create(array(
            'code' => 'TRUCK_UNLOADING',
            'description' => 'Разгружается'
        ));

        /*
         *              Типы грузовиков
         */

        $truck_type = TruckType::create(array(
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

        /*
         *              Страны
         */

        $country = Country::create(array(
            'name'  => 'Республика Казахстан',
            'short'    => 'Казахстан',
            'code'  => 'KZ',
        ));

        Country::create(array(
            'name'  => 'Российская Федерация',
            'short'    => 'Россия',
            'code'  => 'RU',
        ));

        /*
         *              Пользователи
         */


        for($i = 0; $i < $this->cnt; $i++)
        {
            $truck = Truck::create(array(
                'truck_type_id' => $truck_type->id,
                'status_id'     => $truck_status->id,
                'gos_number'    => 'F154AAA',
                'brand'         => 'Мерседес',
                'seria'         => 'С230',
                'volume'        => 40,
                'width'         => 2.5,
                'length'        => 8,
                'capacity'      => 2,
            ));

            $user = User::create(array(
                'is_admin'  => $i == 1,
                'name'      => 'Данияр' . $i,
                'surname'   => 'Саумбаев' . $i,
                'father'    => 'Карияевич' . $i,
                'email'     => 'danixoid' . $i . '@gmail.com',
                'password'  => Hash::make('Roamer'),
                'truck_id'  => $truck->id,
                'country_id'=> $country->id,
                'resident'  => TRUE,
            ));

            /*
             *              Лог Геолокации Грузовиков
             */

            $lat = 50.41667938232422;
            $lng = 80.26166534423828;
            $track_cnt = mt_rand(4,10);

            for ($j = 0; $j < $track_cnt; $j++)
            {
                Track::create(array(
                    'user_id' => $user->id,
                    'lat' => $this->randomCoord($lat),
                    'lng' => $this->randomCoord($lng),
                ));
            }
        }
    }

    private function randomCoord($l) {
        $step = 10000;
        $min = ($l - 0.1) * $step; // было 0.03
        $max = ($l + 0.1) * $step;
        return (mt_rand($min, $max)) / $step;
    }
}