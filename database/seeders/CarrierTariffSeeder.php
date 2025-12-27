<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\CarrierTariff;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarrierTariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarrierTariff::truncate();

        // airlines
        $emirates = Carrier::where('carrier', 'EK')->first();
        $etihad = Carrier::where('carrier', 'EY')->first();
        $pia = Carrier::where('carrier', 'PK')->first();
        $saudi = Carrier::where('carrier', 'SV')->first();
        $jordanian = Carrier::where('carrier', 'RJ')->first();
        $lotPolish = Carrier::where('carrier', 'LO')->first();
        $airTransat = Carrier::where('carrier', 'TS')->first();

        // truckings
        $polaris = Carrier::where('carrier', 'POLARIS')->first();
        $ensureFreight = Carrier::where('carrier', 'ENSUREFREIGHT')->first();
        
        $now = Carbon::now();

        // General Cargo
        if ($emirates) {

            $res[] = [
                'carrier_id' => $emirates->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($etihad) {

            $res[] = [
                'carrier_id' => $etihad->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($pia) {

            $res[] = [
                'carrier_id' => $pia->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($saudi) {

            $res[] = [
                'carrier_id' => $saudi->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($jordanian) {

            $res[] = [
                'carrier_id' => $jordanian->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($lotPolish) {

            $res[] = [
                'carrier_id' => $lotPolish->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($airTransat) {

            $res[] = [
                'carrier_id' => $airTransat->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }



        if ($polaris) {

            $res[] = [
                'carrier_id' => $polaris->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        if ($ensureFreight) {

            $res[] = [
                'carrier_id' => $ensureFreight->id,
                'cargo_type' => 1,
                'created_at' => $now,
            ];
        }

        // DGR PAX
        if ($emirates) {

            $res[] = [
                'carrier_id' => $emirates->id,
                'cargo_type' => 2,
                'created_at' => $now,
            ];
        }


        DB::table('carrier_tariffs')->insert($res);

    }
}
