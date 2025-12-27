<?php

namespace App\Repositories\Airport;

use App\Models\Airport;
use App\Repositories\BaseRepository;

class AirportRepository extends BaseRepository implements IAirport
{
    public function __construct(Airport $airport)
    {
        $this->model = $airport;
    }

    public function search($keyword)
    {
        $select = ['id', 'iata_code', 'city_id', 'country_id'];

        $query = Airport::select($select)->with('city:id,name', 'country:id,iso2');

        if (!empty($keyword)) {
            $airports = $query->where('iata_code', 'like', "%$keyword%")
                ->orWhereHas('city', function ($cityQuery) use ($keyword) {
                    $cityQuery->where('name', 'like', "%$keyword%");
                })
                ->orWhereHas('country', function ($countryQuery) use ($keyword) {
                    $countryQuery->where('iso2', 'like', "%$keyword%");
                })
                ->limit(constants('pagination.limit'))
                ->get();
        } else {
            $airports = $query->limit(constants('pagination.limit'))->get();
        }

        return $airports->toArray();
    }
}
