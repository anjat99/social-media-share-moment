<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $categories = [
        "Standard Collection",
        "A Journal for my child",
        "Memories"
    ];

    private $descriptions = [
        "Family sharing? Hobby group? Office? Great for organizing your stories. Optionally share it with select friends so they can add stories too.",
        "In just 2 minutes every other week, create a story about your child. Whether it's a precious moment or just a slice of life, it'll be a treasure for you and your child to look back on one day!",
        "Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!"
    ];

    public function run()
    {
        for ($i = 0, $iMax = count($this->categories); $i < $iMax; $i++){
            DB::table('categories')->insert([
                'name' => $this->categories[$i],
                'description' => $this->descriptions[$i]
            ]);
        }
    }
}
