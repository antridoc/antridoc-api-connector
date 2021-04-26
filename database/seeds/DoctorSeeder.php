<?php

use Illuminate\Database\Seeder;
use App\Poli;
use App\Doctor;
use Faker\Factory;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create("id_ID");

        $poli = Poli::orderBy("created_at", "desc")->first();

        for ($total = 0; $total < 10; $total++) {
            Doctor::insert([
                "name" =>  $faker->name,
                "poli_id" => $poli->id
            ]);
        }
    }
}
