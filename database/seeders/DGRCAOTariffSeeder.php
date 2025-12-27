<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DGRCAOTariffSeeder extends Seeder
{
    private static $jsonFilePath = __DIR__ . '/archive/DGRCAOTariff.json';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        if (file_exists(self::$jsonFilePath)) {
            $jsonContent = file_get_contents(self::$jsonFilePath);
            $jsonData = json_decode($jsonContent, true);

            $airlineTariffsData = [];

            foreach ($jsonData as $tariffRate) {

                $airlineTariffsData[] = [
                    'min_weight' => $tariffRate['min_weight'],
                    'max_weight' => $tariffRate['max_weight'],
                    'rate' => (float)$tariffRate['rate'],
                    'carrier_tariff_id' => $tariffRate['carrier_tariff_id'],
                    'origin_code' => $tariffRate['origin_code'],
                    'destination_code' => $tariffRate['destination_code'],
                    'created_at' => $now,
                ];
            }

            // Insert data into the cargo_rates table
            DB::table('tariff_details')->insert($airlineTariffsData);
        }
    }
}
