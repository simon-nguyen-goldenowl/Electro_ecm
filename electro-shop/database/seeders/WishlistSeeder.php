<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wishlists')->insert([
            [
                'customer_id' => '2',
                'product_id' => '15'
            ],
            [
                'customer_id' => '2',
                'product_id' => '19'
            ],
            [
                'customer_id' => '3',
                'product_id' => '93'
            ],
            [
                'customer_id' => '3',
                'product_id' => '9'
            ],
            [
                'customer_id' => '3',
                'product_id' => '150'
            ],
        ]);
    }
}
