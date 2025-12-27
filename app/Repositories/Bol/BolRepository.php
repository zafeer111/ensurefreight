<?php

namespace App\Repositories\Bol;

use App\Models\BOL;
use App\Repositories\Bol\IBol;

class BolRepository implements IBol
{
    public function create(array $data)
    {
        return BOL::create($data);
    }
}