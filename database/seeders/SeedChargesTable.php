<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\CarrierCharge;
use App\Models\ChargeType;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedChargesTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarrierCharge::truncate();
        
        $caCurrency = $this->getCurrencyId(Currency::CODE['CAD']);
        $usCurrency = $this->getCurrencyId(Currency::CODE['USD']);
        $chargesTypes = ChargeType::all();
        $res = [];

        $emirates = Carrier::where('carrier', 'EK')->first();
        $etihad = Carrier::where('carrier', 'EY')->first();
        $pia = Carrier::where('carrier', 'PK')->first();
        $saudi = Carrier::where('carrier', 'SV')->first();
        $jordanian = Carrier::where('carrier', 'RJ')->first();
        $lotPolish = Carrier::where('carrier', 'LO')->first();
        $airTransat = Carrier::where('carrier', 'TS')->first();


        $polaris = Carrier::where('carrier', 'POLARIS')->first();
        $ensureFreight = Carrier::where('carrier', 'ENSUREFREIGHT')->first();


        // Airline Carriers

        if ($emirates) {

            $res[] = [
                'carrier_id' => $emirates->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 0
            ];
            $res[] = [
                'carrier_id' => $emirates->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0.97,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];

            $res[] = [
                'carrier_id' => $emirates->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 50,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];
        }

        if ($etihad) {
            $res[] = [
                'carrier_id' => $etihad->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 40
            ];
            $res[] = [
                'carrier_id' => $etihad->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0.07,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];
            $res[] = [
                'carrier_id' => $etihad->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 50,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];

        }

        if ($saudi) {
            $res[] = [
                'carrier_id' => $saudi->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 25
            ];

            $res[] = [
                'carrier_id' => $saudi->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0.15,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];
            $res[] = [
                'carrier_id' => $saudi->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 50,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];

        }

        if ($pia) {

            $res[] = [
                'carrier_id' => $pia->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 0
            ];

            $res[] = [
                'carrier_id' => $pia->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];

            $res[] = [
                'carrier_id' => $pia->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 50,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];
        }

        if ($jordanian) {

            $res[] = [
                'carrier_id' => $jordanian->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 0
            ];

            $res[] = [
                'carrier_id' => $jordanian->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];

            $res[] = [
                'carrier_id' => $jordanian->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 0,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];
        }

        if ($lotPolish) {

            $res[] = [
                'carrier_id' => $lotPolish->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 0
            ];

            $res[] = [
                'carrier_id' => $lotPolish->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0.15,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];

            $res[] = [
                'carrier_id' => $lotPolish->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 0,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];
        }

        if ($airTransat) {

            $res[] = [
                'carrier_id' => $airTransat->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['airable_fee'])->id,
                'charges_amt' => 0
            ];

            $res[] = [
                'carrier_id' => $airTransat->id,
                'currency_id' => $caCurrency->id,
                'charges_amt' => 0.15,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['surcharge'])->id,
            ];

            $res[] = [
                'carrier_id' => $airTransat->id,
                'currency_id' => $usCurrency->id,
                'charges_amt' => 0,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['custom_charges'])->id,
            ];
        }


        // Trucking Carriers

        if ($polaris) {
            $res[] = [
                'carrier_id' => $polaris->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['bonded_charges'])->id,
                'charges_amt' => 50
            ];

        }

        if ($ensureFreight) {
            $res[] = [
                'carrier_id' => $ensureFreight->id,
                'currency_id' => $caCurrency->id,
                'charge_type_id' => $chargesTypes->firstWhere('slug', ChargeType::SLUG['bonded_charges'])->id,
                'charges_amt' => 50
            ];

        }

        DB::table('carrier_charges')->insert($res);

    }

    private function getCurrencyId($code)
    {
        return Currency::where('code', $code)->first();
    }

}
