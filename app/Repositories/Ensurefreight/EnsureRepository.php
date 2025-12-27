<?php

namespace App\Repositories\Ensurefreight;

use App\Models\TruckingPickupCharge;

class EnsureRepository implements IEnsure
{
    public function getRateByWeight($weight)
    {
        return TruckingPickupCharge::where('min_weight', '<=', $weight)
            ->where('max_weight', '>=', $weight)
            ->first();
    }
}