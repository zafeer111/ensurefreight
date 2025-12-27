<?php

namespace Database\Seeders;

use App\Models\AirlineAddress;
use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirlineAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AirlineAddress::truncate();
        
        $addresses = [
            [
                'carrier_name' => 'ETIHAD Airways',
                'address' => '6500 Silver Dart Drive',
                'sub_address' => 'Swissport Canada Handling Inc',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L5P 1A2',
                'port' => '0497',
                'sub_location' => '3775',
                'contact' => 'prakash.cavel@swissport.com',
                'tel' => '905-6762888, 416-4590310'
            ],
            [
                'carrier_name' => 'Emirates',
                'address' => '2710 Britannia Road E, Door 7, Dock 34 - 49',
                'sub_address' => '',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L4W 1S9',
                'port' => '0497',
                'sub_location' => '5502',
                'contact' => '',
                'tel' => '905-6762888, 905-6730388'
            ],
            [
                'carrier_name' => 'Saudi Arabian Airlines',
                'address' => '2710 Britannia Road E, Door 7, Dock 34 - 49',
                'sub_address' => 'GTA DNATA',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L4W 1S9',
                'port' => '0497',
                'sub_location' => '5502',
                'contact' => '',
                'tel' => '905-6762888, 905-6730388'
            ],
            [
                'carrier_name' => 'Pakistan International Airlines',
                'address' => 'Vista Cargo Complex, 6500 Silver Dart Drive, Building C, D',
                'sub_address' => 'Air Cargo Inc',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L5P 1B2',
                'port' => '0497',
                'sub_location' => '5154',
                'contact' => '',
                'tel' => '905-6714688'
            ],
            [
                'carrier_name' => 'SILK WAY WEST AIRLINES',
                'address' => 'Vista Cargo Complex, 6500 Silver Dart Drive, Building C, D',
                'sub_address' => 'Air Cargo Inc',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L5P 1B2',
                'port' => '0497',
                'sub_location' => '5154',
                'contact' => '',
                'tel' => '905-6714688'
            ],
            [
                'carrier_name' => 'TAP Air Portugal',
                'address' => 'Vista Cargo Complex, 6500 Silver Dart Drive, Building C, D',
                'sub_address' => 'Air Cargo Inc',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L5P 1B2',
                'port' => '0497',
                'sub_location' => '5154',
                'contact' => '',
                'tel' => '905-6714688'
            ],
            [
                'carrier_name' => 'Royal Jordanian',
                'address' => '2710 Britannia Road E, Door 5',
                'sub_address' => 'Cargo Airport Services (Air Algeire)',
                'city' => 'Mississauga',
                'state' => 'Ontario',
                'postal_code' => 'L4W 1S9',
                'port' => '0497',
                'sub_location' => '4718',
                'contact' => '',
                'tel' => '905-6762888, 905-6730388'
            ],
        ];

        foreach ($addresses as $addressData) {
            $carrier = Carrier::where('carrier_name', $addressData['carrier_name'])->first();

            if ($carrier) {
                AirlineAddress::create([
                    'carrier_id' => $carrier->id,
                    'address' => $addressData['address'],
                    'sub_address' => $addressData['sub_address'],
                    'city' => $addressData['city'],
                    'state' => $addressData['state'],
                    'postal_code' => $addressData['postal_code'],
                    'port' => $addressData['port'],
                    'sub_location' => $addressData['sub_location'],
                    'contact' => $addressData['contact'],
                    'tel' => $addressData['tel'],
                ]);
            }
        }
    }
}