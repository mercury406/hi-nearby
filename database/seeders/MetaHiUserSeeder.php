<?php

namespace Database\Seeders;

use App\Models\MetaHiUser;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class MetaHiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 8; $i < 100; $i++)
        MetaHiUser::create([
            "username" => Str::random(10),
        ]);

    }
}
