<?php

namespace Database\Seeders;

use App\Models\KTPIdentification;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KTPSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $rt = $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $dt = $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now');
        $date = $dt->format("Y-m-d"); // 1994-09-24

//        YYYY-MM-DD
        for ($i = 0; $i < 300; $i++) {
            try {
                $nik = $faker->numberBetween(000000000001, 900000000000);
                $no_kk = $faker->numberBetween(100000000000, 190000000000);
                $jk = $faker->numberBetween(1, 2);

                $this->insert($faker->name, $date, $faker->state, $nik,$no_kk, $jk, $faker->address);
            } catch (Exception $exception) {
                continue;
            }
        }
    }

//user_id	name	birth_date	nik	no_kk	jk	alamat	photo_requested	birth_place	photo_face	photo_stored	verified_at
    function insert($name, $birth_date, $birth_place, $nik,$no_kk, $jk, $alamat)
    {
        $data = new KTPIdentification();
        $data->name = $name;
        $data->user_id = null;
        $data->birth_date = $birth_date;
        $data->birth_place = $birth_place;
        $data->nik = $nik;
        $data->no_kk = $no_kk;
        $data->alamat = $alamat;
        $data->save();
    }
}
