<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnsureTruckingRequest;
use App\Services\EnsureTruckingService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnsureTruckingController extends Controller
{
    protected $truckingService;

    public function __construct(EnsureTruckingService $truckingService)
    {
        $this->truckingService = $truckingService;
    }

    public function calculateCharge(EnsureTruckingRequest $request)
    {
        $weight = $request->input('weight');
        $measurements = $request->input('measurements');
        $totalSkids = array_sum(array_column($measurements, 'quantity'));

        // if ($totalSkids > 4) {
        //     throw new HttpException(422,constants('exception_messages.max_skids_exceeded'));
        // }

        $charge = $this->truckingService->calculateCharge($weight);
        
        if (!$charge) {
            return response()->json(['error' => 'Weight range not found'], 404);
        }

        return response()->json(['charge' => $charge], 200);
    }
}