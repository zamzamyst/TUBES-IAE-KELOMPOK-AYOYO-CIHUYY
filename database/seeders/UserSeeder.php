<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    $admin->assignRole('admin');
    
        $seller = User::firstOrCreate([
        'name' => 'seller',
        'email' => 'seller@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    $seller->assignRole('seller');

        $customer = User::firstOrCreate([
        'name' => 'customer',
        'email' => 'customer@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    $customer->assignRole('customer');

    }
}
