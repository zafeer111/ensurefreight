<?php

namespace Database\Seeders;

use App\Jobs\AirportBulkInsert;
use App\Models\Airport;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AirportSeeder extends Seeder
{
    private static $jsonFilePath = __DIR__ . '/archive/airport.json';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('airports')->truncate();

        if (file_exists(self::$jsonFilePath)) {
            $jsonContent = file_get_contents(self::$jsonFilePath);
            $jsonData = json_decode($jsonContent, true);
            if ($jsonData !== null) {
                $this->executeAirportData($jsonData);
            } else {
                echo "JSON file exists, but there was an error parsing it.";
            }
        } else {
            echo "JSON file does not exist at the specified path.";
        }
    }

    private function executeAirportData($airports)
    {
        $batchSize = 500;
        $chunks = array_chunk($airports, $batchSize);

        foreach ($chunks as $chunk) {
            AirportBulkInsert::dispatch($chunk);
        }

        echo 'DONE'.PHP_EOL;
    }




}
