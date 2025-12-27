<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CustomerSeeder extends Seeder
{
    private static $jsonFilePath = __DIR__ . '/archive/companies.json';


    public function run(): void
    {
        if (file_exists(self::$jsonFilePath)) {
            $jsonContent = file_get_contents(self::$jsonFilePath);
            $jsonData = json_decode($jsonContent, true);

            if ($jsonData !== null) {
                $this->seedCustomers($jsonData);
            } else {
                echo "JSON file exists, but there was an error parsing it.";
            }
        } else {
            echo "JSON file does not exist at the specified path.";
        }
    }

    private function seedCustomers($customerData)
    {
        $timeStamp = now();
        $customers = [];

        foreach ($customerData as $key => $company) {
            $cityName = $company['CCity'];
            $archiveData = json_encode($company);

            $city = City::where('name', 'like', $company['CCity'] . '%')->first();
            $airportId = null;

            if ($company['CIATANo'] !== null && $company['CIATANo'] !== '') {
                $airport = Airport::where('iata_code', 'like', $company['CIATANo'] . '%')->first();
                $airportId = $airport ? $airport->id : null;
            }

            $customerUuid = Str::uuid();

            $customers[] = [
                'id' => $company['CID'],
                'name' => $company['Cname'],
                'address' => $company['CAdd1'] . PHP_EOL . $company['CAdd2'],
                'postal_code' => $company['CPostal'],
                'phone' => $company['CContact1'],
                'airport_id' => $airportId,
                'alternate_phone_no' => $company['CContact2'],
                'email' => $company['CEmail'],
                'account_no' => $company['CAccountNo'],
                'customer_uuid' => $customerUuid,
                'archive_data' => $archiveData,
                'created_at' => $timeStamp,
                'city_id' => $city ? $city->id : null,
                'country_id' => $city ? $city->country_id : null,
                'state_id' => $city ? $city->state_id : null,
            ];
        }

        try {
            Customer::insert($customers);
            echo 'DONE';
        }
        catch (\Exception $e) {
            Log::error('Error bulk inserting customers: ' . $e->getMessage());
            echo 'Error occurred while seeding customers.';
        }
    }

}
