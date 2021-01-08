<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
             'code' => 'O0001',
             'customer_id' => '2',
             'name' => 'Nguyen Van B',
             'address' => '123 aaa Ho Chi Minh',
             'phone' => '123456789',
             'email' => 'mrst8720@gmail.com',
             'order_status' => '1',
             'payment_status' => '5',
             'shipping_status' => '7',
             'note' => null,
            ],
            [
             'code' => 'O0002',
             'customer_id' => '2',
             'name' => 'Nguyen Van B',
             'address' => '123 aaa Ho Chi Minh',
             'phone' => '123456789',
             'email' => 'mrst8720@gmail.com',
             'order_status' => '1',
             'payment_status' => '4',
             'shipping_status' => '6',
             'note' => null,
            ],
            [
             'code' => 'O0003',
             'customer_id' => '3',
             'name' => 'Nguyen Van C',
             'address' => '123 aaa Ho Chi Minh',
             'phone' => '123456789',
             'email' => 'nvc@gmail.com',
             'order_status' => '1',
             'payment_status' => '5',
             'shipping_status' => '6',
             'note' => null,
            ],
            [
             'code' => 'O0004',
             'customer_id' => '3',
             'name' => 'Nguyen Van C',
             'address' => '123 aaa Ho Chi Minh',
             'phone' => '123456789',
             'email' => 'nvc@gmail.com',
             'order_status' => '2',
             'payment_status' => null,
             'shipping_status' => null,
             'note' => 'Internet Problem',
            ],
            [
             'code' => 'O0005',
             'customer_id' => '3',
             'name' => 'Nguyen Van C',
             'address' => '123 aaa Ho Chi Minh',
             'phone' => '123456789',
             'email' => 'nvc@gmail.com',
             'order_status' => '3',
             'payment_status' => null,
             'shipping_status' => null,
             'note' => 'Duplicate Order O0003',
            ],
            [
             'code' => 'O0006',
             'customer_id' => null,
             'name' => 'Nguyen Van D',
             'address' => '1234 aaa Ho Chi Minh',
             'phone' => '1223456789',
             'email' => 'nvd@gmail.com',
             'order_status' => '1',
             'payment_status' => '5',
             'shipping_status' => '7',
             'note' => 'Guest',
            ],
        ]);
    }
}
