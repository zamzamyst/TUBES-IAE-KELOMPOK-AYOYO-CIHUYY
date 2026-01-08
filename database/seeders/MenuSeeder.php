<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('mysql_menu')->table('menus')->insert([
            [
                'menu_code' => 'ABC001',
                'name' => 'Produk A',
                'price' => '100000',
                'description' => 'Enak Sehat Bergizi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'XYZ009',
                'name' => 'Produk B',
                'price' => '200000',
                'description' => 'Murah dan Mengenyangkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
