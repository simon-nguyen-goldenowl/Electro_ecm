<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          CategorySeeder::class,
          BrandSeeder::class,
          ProductSeeder::class,
          UserSeeder::class,
          StatusSeeder::class,
          OrderSeeder::class,
          OrderDetailSeeder::class,
          WishlistSeeder::class,
          ReviewSeeder::class
        ]);
    }
}
