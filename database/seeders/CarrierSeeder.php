<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarrierSeeder extends Seeder
{
    private static $jsonFilePath = __DIR__ . '/archive/carrier.json';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carriers')->truncate();
        
        $now = Carbon::now();

        if (file_exists(self::$jsonFilePath)) {
            $jsonContent = file_get_contents(self::$jsonFilePath);
            $jsonData = json_decode($jsonContent, true);

            foreach ($jsonData as $carrier) {
                $attributes = [
                    'carrier' => $carrier['Carrier'],
                    'carrier_name' => $carrier['CarrierName'],
                    'type' => $carrier['type'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            
                if (!empty($carrier['code'])) {
                    $attributes['carrier_code'] = $carrier['code'];
                    DB::table('carriers')->updateOrInsert(
                        ['carrier_code' => $carrier['code']],
                        $attributes
                    );
                } else {
                    // For cases where code is empty, use carrier as unique identifier
                    DB::table('carriers')->updateOrInsert(
                        ['carrier' => $carrier['Carrier']],
                        $attributes
                    );
                }
            }
            
        
        }
        
    }
}