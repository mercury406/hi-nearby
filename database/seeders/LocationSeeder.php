<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 8; $i < 100; $i++)
        Location::create([
            "user_id" => $i,
            "latitude" => mt_rand(0, 360) + mt_rand(100000, 999999)/1000000,
            "longitude" => mt_rand(0, 360) + mt_rand(100000, 999999)/1000000
        ]);
    }
}
