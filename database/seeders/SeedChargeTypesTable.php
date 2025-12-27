<?php

namespace Database\Seeders;

use App\Models\ChargeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedChargeTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChargeType::truncate();

        $date = date('Y-m-d H:i:s');
        $res = [
            [
                'name' => 'Airbable Fee',
                'slug' => ChargeType::SLUG['airable_fee'],
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Custom Charges',
                'slug' => ChargeType::SLUG['custom_charges'],
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Surcharge',
                'slug' => ChargeType::SLUG['surcharge'],
                'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'name' => 'Bonded Charges',
                'slug' => ChargeType::SLUG['bonded_charges'],
                'created_at' => $date,
                'updated_at' => $date
            ]
        ];

        ChargeType::insert($res);
    }
}
