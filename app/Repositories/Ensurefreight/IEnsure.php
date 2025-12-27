<?php

namespace App\Repositories\Ensurefreight;

interface IEnsure
{
    public function getRateByWeight($weight);
}