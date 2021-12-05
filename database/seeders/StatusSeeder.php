<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $statuses = [
        "public",
        "private",
        "friends"
    ];

    public function run()
    {
        foreach ($this->statuses as $status) {
            DB::table('statuses')->insert([
                "name" => $status
            ]);
        }
    }
}
