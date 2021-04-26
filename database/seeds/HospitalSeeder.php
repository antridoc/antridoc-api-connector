<?php

use Illuminate\Database\Seeder;
use App\Hospital;
use Faker\Factory;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create("id_ID");

        for ($total = 0; $total < 10; $total++) {
            Hospital::insert([
                "name" => $faker->name
            ]);
        }
    }
}
