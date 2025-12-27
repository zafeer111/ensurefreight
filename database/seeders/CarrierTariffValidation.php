<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\CarrierTariff;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarrierTariffValidation extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carrier_tariff_validations')->truncate();

        $now = now();
        $validations = [];

        // Airline Carriers

        // Emirates
        $emiratesTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'EK')->value('id'))->first();
        if ($emiratesTariff) {
            $validations[] = [
                'carrier_tariff_id' => $emiratesTariff->id,
                'valid_at' => Carbon::parse('2023-12-15'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Etihad
        $etihadTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'EY')->value('id'))->first();
        if ($etihadTariff) {
            $validations[] = [
                'carrier_tariff_id' => $etihadTariff->id,
                'valid_at' => Carbon::parse('2024-04-01'),
                'expire_at' => Carbon::parse('2024-10-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // PIA
        $piaTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'PK')->value('id'))->first();
        if ($piaTariff) {
            $validations[] = [
                'carrier_tariff_id' => $piaTariff->id,
                'valid_at' => Carbon::parse('2023-12-01'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Saudi
        $saudiTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'SV')->value('id'))->first();
        if ($saudiTariff) {
            $validations[] = [
                'carrier_tariff_id' => $saudiTariff->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Royal Jordanian
        $jordanianTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'RJ')->value('id'))->first();
        if ($jordanianTariff) {
            $validations[] = [
                'carrier_tariff_id' => $jordanianTariff->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // LOT Polish Airlines
        $lotPolishTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'LO')->value('id'))->first();
        if ($lotPolishTariff) {
            $validations[] = [
                'carrier_tariff_id' => $lotPolishTariff->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Air Transat
        $airTransatTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'TS')->value('id'))->first();
        if ($airTransatTariff) {
            $validations[] = [
                'carrier_tariff_id' => $airTransatTariff->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        
        // Trucking Carriers

        // polaris
        $polarisTariff = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'POLARIS')->value('id'))->first();
        if ($polarisTariff) {
            $validations[] = [
                'carrier_tariff_id' => $polarisTariff->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-03-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // ensurefreight
        $ensureFreight = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'ENSUREFREIGHT')->value('id'))->first();
        if ($ensureFreight) {
            $validations[] = [
                'carrier_tariff_id' => $ensureFreight->id,
                'valid_at' => Carbon::parse('2023-12-02'),
                'expire_at' => Carbon::parse('2024-03-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        // Emirates DGR PAX
        $emiratesPAX = CarrierTariff::where('carrier_id', Carrier::where('carrier', 'EK')->value('id'))
                                ->where('cargo_type', 2)
                                ->first();
        if ($emiratesPAX) {
            $validations[] = [
                'carrier_tariff_id' => $emiratesPAX->id,
                'valid_at' => Carbon::parse('2023-12-15'),
                'expire_at' => Carbon::parse('2024-05-31'),
                'max_height' => 63,
                'max_width' => 96,
                'max_length' => 125,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('carrier_tariff_validations')->insert($validations);
    }
}
