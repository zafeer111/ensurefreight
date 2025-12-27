<?php

namespace App\Services;

use App\Models\Currency;
use App\Repositories\Ensurefreight\IEnsure;

class EnsureTruckingService
{
    protected $truckingRepository;

    public function __construct(IEnsure $truckingRepository)
    {
        $this->truckingRepository = $truckingRepository;
    }

    public function calculateCharge($weight)
    {
        $cadConversion = Currency::where('code', 'CAD')->value('unit_per_usd');

        $rate = $this->truckingRepository->getRateByWeight($weight);
        if (!$rate) {
            return null; // Weight range not found
        }

        if ($rate->is_fixed) {
            // Return fixed rate directly
            $fixedRateCad = $rate->min_rate / $cadConversion;
            return (int) $fixedRateCad;
        }

        // Perform linear interpolation to calculate the rate
        $rateFactor = $rate->min_rate + (($rate->max_rate - $rate->min_rate) / ($rate->max_weight - $rate->min_weight)) * ($weight - $rate->min_weight);

        $interpolatedRateCad = $rateFactor * $weight / $cadConversion;
        return $interpolatedRateCad;
    }
}