<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorys = ['food', 'bakery', 'drink'];
        $n = 1;

        foreach ($categorys as $key => $item) {
            $category = new Category();
            $category->id = $n;
            $category->name = $item;
            $category->save();

            $n++;
        }
    }
}
