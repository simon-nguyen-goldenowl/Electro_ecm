<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductFactory::times(200)->create();
    }
}
