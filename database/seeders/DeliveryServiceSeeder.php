<?php

namespace Database\Seeders;

use App\Models\DeliveryService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Regular',
                'price' => 20000,
                'estimation_days' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Express',
                'price' => 50000,
                'estimation_days' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Next Day',
                'price' => 100000,
                'estimation_days' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Same Day',
                'price' => 150000,
                'estimation_days' => 0,
                'is_active' => false,
            ],
        ];

        foreach ($services as $service) {
            DeliveryService::firstOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
