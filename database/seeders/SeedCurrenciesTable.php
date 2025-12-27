<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedCurrenciesTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::truncate();

        $currencies = [
            [
                'country_id' => 236,
                'unit_per_usd' => 1,
                'usd_per_unit' => 1,
                'symbol' => '$',
                'name' => 'US Dollar',
                'symbol_native' => '$',
                'decimal_mark' => 2,
                'code' => 'USD',
            ],
            [
                'country_id' => 39,
                'symbol' => 'CA$',
                'unit_per_usd' => 0.77,
                'usd_per_unit' => 1.36,
                'name' => 'Canadian Dollar',
                'symbol_native' => '$',
                'decimal_mark' => 2,
                'code' => 'CAD',
            ],
            // Add more currencies if needed
        ];

        // Insert data into the 'currencies' table
        DB::table('currencies')->insert($currencies);
    }
}
