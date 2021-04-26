<?php

use Illuminate\Database\Seeder;
use App\Hospital;
use App\Poli;
use Faker\Factory;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create("id_ID");

        $hospital = Hospital::orderBy("created_at", "desc")->first();

        for ($total = 0; $total < 10; $total++) {
            Poli::insert([
                "name" => $faker->name,
                "hospital_id" => $hospital->id
            ]);
        }

    }
}
