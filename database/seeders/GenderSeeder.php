<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $genders = [
        "male",
        "female"
    ];

    public function run()
    {
        foreach ($this->genders as $gender) {
            DB::table('genders')->insert([
                "name" => $gender
            ]);
        }
    }
}
