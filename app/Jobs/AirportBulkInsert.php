<?php

namespace App\Jobs;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use function Livewire\of;

class AirportBulkInsert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = [];
        $timeStamp = now();

        foreach ($this->data as $airport) {

            if ($airport['iata'] == null || $airport['iata'] == "" || $airport['city'] == "" || $airport['city'] == null
                || $airport['country'] == null || $airport['country'] == "") {
                continue;
            }


            $city = City::
            select('cities.id','cities.state_id','cities.country_id','countries.iso2')
                ->where('cities.name', 'LIKE','%'. $airport['city'] . '%')
                ->where('countries.iso2', $airport['country'])
                ->join('countries', 'countries.id', 'cities.country_id')
                ->first();
            if (empty($city)){
                continue;
            }

            // Check if iata_code and city are not null and not empty strings before inserting

            $result[] = [
                'name' => $airport['name'],
                'iata_code' => $airport['iata'],
                'city_id' => $city->id,
                'country_id' => $city->country_id,
                'state_id' => $city->state_id,
                'created_at' => $timeStamp,
                'updated_at' => $timeStamp, // Adjust if needed
            ];

        }

        Airport::insert($result);

    }
}
