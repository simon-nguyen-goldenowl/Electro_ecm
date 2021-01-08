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
    public function run()
    {
        DB::table('statuses')->insert([
            ['name' => 'Success','type' => 'O'],
            ['name' => 'Failure','type' => 'O'],
            ['name' => 'Cancel','type' => 'O'],
            ['name' => 'Pending','type' => 'P'],
            ['name' => 'Paid','type' => 'P'],
            ['name' => 'Shipping','type' => 'S'],
            ['name' => 'Shipped','type' => 'S'],
        ]);
    }
}
