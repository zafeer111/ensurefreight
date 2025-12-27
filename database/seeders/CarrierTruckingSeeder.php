<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarrierTruckingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carrier = [
            'carrier' => 'POLARIS',
            'carrier_name' => 'Polaris Trucking',
            'type' => 2,
            'status' => 1,
        ];
        
    $carrierId = Carrier::create($carrier);

    if ($carrier){
        $carrierDetails = [
            'carrier_id' => $carrierId->id,
            'endpoint' => 'https://api.polaristransport.com:1984/restgateway/services/RateAPI/Rate',
            'token' => 'MzQ1NDI5OTQzMTE5MzQ4NQ'
        ];

        DB::table('carrier_details')->insert($carrierDetails);
    }

    }
}
