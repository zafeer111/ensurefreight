<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineTariffSeeder extends Seeder
{
    private static $jsonFilePath = __DIR__ . '/archive/airline_tariffs.json';

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

            foreach ($jsonData as $tariff) {
                $airlineTariffsData[] = [
                    'carriers_id' => $tariff['carriers_id'],
                    'type' => $tariff['type'],
                    'valid_at' => $tariff['valid_at'],
                    'expire_at' => $tariff['expire_at'],
                    'cad_usd_conversion_rate' => $tariff['cad_usd_conversion_rate'],
                    'airbable_fee' => $tariff['airbable_fee'],
                    'airbable_fee_currency' => $tariff['airbable_fee_currency'],
                    'surcharge' => $tariff['surcharge'],
                    'surcharge_currency' => $tariff['surcharge_currency'],
                    'custom_charges' => $tariff['custom_charges'],
                    'custom_charges_currency' => $tariff['custom_charges_currency'],
                    'max_height' => $tariff['max_height'],
                    'max_width' => $tariff['max_width'],
                    'max_length' => $tariff['max_length'],
                    'created_at' => $now,
                ];
            }

            // Insert data into the airline_tariffs table
            DB::table('airline_tariffs')->insert($airlineTariffsData);
        }
    }
}