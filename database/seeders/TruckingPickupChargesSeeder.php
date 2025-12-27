<?php

namespace Database\Seeders;

use App\Models\TruckingPickupCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckingPickupChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TruckingPickupCharge::truncate();

        $charges = [
            ['min_weight' => 100, 'max_weight' => 300, 'min_rate' => 300, 'max_rate' => 300, 'is_fixed' => true],
            ['min_weight' => 300, 'max_weight' => 350, 'min_rate' => 1.00, 'max_rate' => 0.98, 'is_fixed' => false],
            ['min_weight' => 350, 'max_weight' => 500, 'min_rate' => 0.98, 'max_rate' => 0.90, 'is_fixed' => false],
            ['min_weight' => 500, 'max_weight' => 1000, 'min_rate' => 0.90, 'max_rate' => 0.70, 'is_fixed' => false],
            ['min_weight' => 1000, 'max_weight' => 2000, 'min_rate' => 0.70, 'max_rate' => 0.60, 'is_fixed' => false],
            ['min_weight' => 2000, 'max_weight' => 3000, 'min_rate' => 0.60, 'max_rate' => 0.50, 'is_fixed' => false],
            ['min_weight' => 3000, 'max_weight' => 5000, 'min_rate' => 0.50, 'max_rate' => 0.40, 'is_fixed' => false],
            ['min_weight' => 5000, 'max_weight' => 12000, 'min_rate' => 0.40, 'max_rate' => 0.30, 'is_fixed' => false],
        ];
        
        foreach ($charges as $charge) {
            $charge['rate_currency'] = 'USD';
            $charge['max_skids'] = 4;
            TruckingPickupCharge::create($charge);
        }
    }
}
