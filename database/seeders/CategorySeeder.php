<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Technology', 'Education', 'Fiction', 'History', 'Business', 'Self Development'];

        foreach ($categories as $name) {
          Category::create(['name' => $name]);
        }
    }
}
