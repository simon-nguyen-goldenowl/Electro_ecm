<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_details')->insert([
            [
                'order_id' => '1',
                'product_id' => '1',
                'price' => '2000',
                'amount' => '1',
                'total' => '2000',
            ],
            [
                'order_id' => '1',
                'product_id' => '4',
                'price' => '1500',
                'amount' => '2',
                'total' => '3000',
            ],
            [
                'order_id' => '2',
                'product_id' => '3',
                'price' => '1500',
                'amount' => '1',
                'total' => '1500',
            ],
            [
                'order_id' => '3',
                'product_id' => '5',
                'price' => '2500',
                'amount' => '1',
                'total' => '2500',
            ],
            [
                'order_id' => '3',
                'product_id' => '6',
                'price' => '1500',
                'amount' => '1',
                'total' => '1500',
            ],
            [
                'order_id' => '5',
                'product_id' => '5',
                'price' => '2500',
                'amount' => '1',
                'total' => '2500',
            ],
            [
                'order_id' => '5',
                'product_id' => '6',
                'price' => '1500',
                'amount' => '1',
                'total' => '1500',
            ],
        ]);
    }
}
