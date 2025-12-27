<?php

if (!function_exists('constants')) {
    function constants($key)
    {
        return config()->has('constants.' . $key) ? config('constants.' . $key) : $key;
    }
}


if (!function_exists('getTariffProfit')) {
    function getTariffProfit($weight)
    {
        $res = 0;
        $profits = constants('profit');
        if (is_array($profits)) {
            foreach ($profits as $profit) {
                if ($weight >= $profit['min_weight'] && $weight < $profit['max_weight']) {
                    $res = $profit['value'];
                    break;
                }
            }
        }

        return $res;
    }
}

if (!function_exists('convertWeightToLbs')) {
    function convertWeightToLbs($weight)
    {
        return round($weight * 2.20462, 2);
    }
}

if (!function_exists('calculateWeightRate')) {
    function calculateWeightRate($weight)
    {
        $weightRanges = constants('weight_ranges');

        $sortedWeights = array_keys($weightRanges);
        rsort($sortedWeights); // Sort weights in descending order

        // Check if the weight is within the defined range
        if ($weight < min($sortedWeights) || $weight > max($sortedWeights)) {
            return null; // Weight is outside the defined range
        }

        // Find the two nearest weights for linear interpolation
        $minWeight = $maxWeight = null;
        foreach ($sortedWeights as $w) {
            if ($w <= $weight) {
                $maxWeight = $w;
                break;
            }
            $minWeight = $w;
        }

        // Linear interpolation to calculate the rate
        $minRate = $weightRanges[$minWeight];
        $maxRate = $weightRanges[$maxWeight];

        $rate = $maxRate + (($minRate - $maxRate) / ($maxWeight - $minWeight)) * ($maxWeight - $weight);

        return round($rate, 2); // Rounding to 2 decimal places
    }
}