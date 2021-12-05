<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table("users")->insert([
            'first_name' => "Anja",
            'last_name' => "Tomić",
            'username' => "admin4you",
            'email' => "anja.tomic099@gmail.com",
            'password' => md5("Admin4Web"),
            'birthdate'=> '1999-08-31',
            'role_id' => 1,
            'gender_id' => 2
        ]);

//        for($i = 0; $i < 30; $i++){
//            DB::table("users")->insert([
//                'first_name' => $faker->firstName,
//                'last_name' => $faker->lastName,
//                'username' => $faker->unique()->userName,
//                'email' => $faker->unique()->safeEmail,
//                'password' => md5("User123!"),
//                'profile_image' => $faker->unique()->imageUrl,
//                'birthdate'=> $faker->dateTimeInInterval($startDate = '- 90 years', $interval = '- 5 years', $timezone = null),
//                'role_id' => 2,
//                'gender_id' => rand(1, 2)
//            ]);
//        }
    }
}
