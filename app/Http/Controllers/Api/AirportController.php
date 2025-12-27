<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Airport\IAirport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    private $airportInterface;

    public function __construct(IAirport $IAirport)
    {
        $this->airportInterface = $IAirport;
    }

    public function airports(Request $request)
    {

        $request->validate([
            'query' => 'nullable|string'
        ]);

        return response()->json($this->airportInterface->search($request->input('query') ?? ""));

    }
}
