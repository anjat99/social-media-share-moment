<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $tags = [
        "art",
        "birthdays",
        "holidays",
        "memorable moments",
        "school",
        "vacations",
        "football game",
        "sweet 16",
        "love",
        "graduation"
    ];

    public function run()
    {
        foreach ($this->tags as $tag) {
            DB::table('tags')->insert([
                "title" => $tag
            ]);
        }
    }
}
