<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'code' => 'U0001',
                'name' => 'Nguyen Van A',
                'address' => '123 aaa Ho Chi Minh',
                'phone' => '123456789',
                'username' => 'admin1',
                'password' => Hash::make('123456789'),
                'email' => 'sachtan.nguyen@gmail.com',
                'is_admin' => '1'
            ],
            [
                'code' => 'U0002',
                'name' => 'Nguyen Van B',
                'address' => '123 aaa Ho Chi Minh',
                'phone' => '123456789',
                'user_name' => 'user1',
                'password' => Hash::make('123456789'),
                'email' => 'mrst8720@gmail.com',
                'is_admin' => '0'
            ],
            [
                'code' => 'U0003',
                'name' => 'Nguyen Van C',
                'address' => '123 aaa Ho Chi Minh',
                'phone' => '123456789',
                'user_name' => 'user2',
                'password' => Hash::make('123456789'),
                'email' => 'user2@gmail.com',
                'is_admin' => '0'
            ],
        ]);
    }
}
