<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Addresses;
use App\Models\AirportCity;
use App\Models\AirportCountry;
use App\Models\Carrier;
use App\Models\CarrierCharge;
use App\Models\CarrierTariff;
use App\Models\CarrierTariffValidation;
use App\Models\ChargeType;
use App\Models\Currency;
use App\Models\TariffDetail;
use Illuminate\Http\Request;
use App\Services\PolarisApiService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AirlineTariffController extends Controller
{
    protected $polarisApiService;

    public function __construct(PolarisApiService $polarisApiService)
    {
        $this->polarisApiService = $polarisApiService;
    }


    public function getAirlineTariff(Request $request)
    {
        $request->validate([
            'origin' => 'required|numeric',
            'weight' => 'required|numeric',
            'type' => 'required|integer',
            'mode' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'measurements' => 'required|array',
            'measurements.*.quantity' => 'required|numeric',
            'measurements.*.length' => 'required|numeric',
            'measurements.*.width' => 'required|numeric',
            'measurements.*.height' => 'required|numeric',
            'measurements.*.chargeable_weight' => 'required|numeric',
            'Inside_Pickup' => 'required|in:Y,N',
            'Residential_Pickup' => 'required|in:Y,N',
            'Lifgate_Pickup' => 'required|in:Y,N',
            'Lifgate_Delivery' => 'required|in:Y,N',
            'Do_Not_Stack' => 'required|in:Y,N',
        ]);

        $origin = $request->input('origin');
        $destIataCode = $request->input('dest');
        $weight = $request->input('weight');
        $type = $request->input('type');
        $mode = $request->input('mode');
        $destPostalCode = $request->input('dest_postal_code');
        $measurements = $request->input('measurements');
        $insidePickup = $request->input('Inside_Pickup', 'N');
        $residentialPickup = $request->input('Residential_Pickup', 'N');
        $lifgatePickup = $request->input('Lifgate_Pickup', 'N');
        $lifgateDelivery = $request->input('Lifgate_Pickup', 'N');
        $doNotStack = $request->input('Do_Not_Stack', 'N');
        $date = $request->input('date');

        $addressData = Addresses::where('id', $origin)->first();

        if (!$addressData) {
            throw new HttpException(422, constants('exception_messages.no_address_found'));
        }

        $cityId = $addressData->city_id;
        $countryId = $addressData->country_id;
        $fromPostalCode = $addressData->postal_code;

        $originData = AirportCity::select('airports.iata_code', 'airports.postal_code')
            ->leftJoin('airports', 'airport_cities.airport_id', '=', 'airports.id')
            ->where('airport_cities.city_id', $cityId)
            ->first();

        if ($originData) {
            $toPostalCode = $originData->postal_code;
            $pickupIataCode = $originData->iata_code;
        } else {
            $originData = AirportCountry::select('airports.iata_code', 'airports.postal_code')
                ->leftJoin('airports', 'airport_countries.airport_id', '=', 'airports.id')
                ->where('airport_countries.country_id', $countryId)
                ->first();

            if ($originData) {
                $toPostalCode = $originData->postal_code;
                $pickupIataCode = $originData->iata_code;
            } else {
                throw new HttpException(422, constants('exception_messages.origin'));
            }
        }

        $cargo = constants('cargo_type.' . $type);
        $airlineMode = constants('inquiry_mode.airline_mode');
        $truckingMode = constants('inquiry_mode.trucking_mode');
        $minSkid = constants('skids.min_skid');
        $maxSkid = constants('skids.max_skid');

        $totalQuantity = array_sum(array_column($measurements, 'quantity'));

        // if ($totalQuantity < $minSkid || $totalQuantity > $maxSkid) {
        //     throw new HttpException(422,constants('exception_messages.max_skids_exceeded'));
        // }

        $weightLbs = convertWeightToLbs($weight);

        // Check if measurements are within the limits
        $this->checkMeasurements($measurements, $weightLbs, $weight);

        $carriers = Carrier::where('status', 1)
            ->where('type', $airlineMode)
            ->with(['carrierTariffs' => function ($query) use ($type) {
                $query->where('cargo_type', $type)
                    ->with('tariffValidations');
            }])
            ->whereHas('carrierTariffs', function ($query) use ($type) {
                $query->where('cargo_type', $type);
            })
            ->with('flights.schedules')
            ->get();

        if ($carriers->isEmpty()) {
            throw new HttpException(422, constants('exception_messages.no_carrier'));
        }

        $truckingCarriers = Carrier::where('status', 1)
            ->where('type', $truckingMode)
            ->with(['carrierTariffs' => function ($query) use ($type) {
                $query->where('cargo_type', $type)
                    ->with('tariffValidations');
            }])
            ->get();

        if (!$truckingCarriers) {
            throw new HttpException(422, constants('exception_messages.no_carrier'));
        }

        // Airline Mode
        if ($mode == $airlineMode) {

            $lowestRateAndCarrier = $this->getLowestRateAndCarrierId($truckingCarriers, $measurements, $fromPostalCode, $toPostalCode, $totalQuantity, $date, $weightLbs, $weight, $insidePickup, $residentialPickup, $lifgatePickup, $lifgateDelivery, $doNotStack);
            $lowestRate = $lowestRateAndCarrier['lowestRate'];
            $lowestRate = floatval(str_replace(',', '', $lowestRate));
            $carrierWithLowestRateId = $lowestRateAndCarrier['carrierWithLowestRateId'];
            $carrierWithLowestRateName = $lowestRateAndCarrier['carrierWithLowestRateName'];

            $result = $this->calculateInternationalTariff($request, $carriers, $lowestRate, $carrierWithLowestRateId, $carrierWithLowestRateName, $weight, $type, $cargo, $pickupIataCode, $destIataCode);

            // Trucking Mode
        } elseif ($mode == $truckingMode) {
            $result = $this->calculateLocalTariff($request, $truckingCarriers, $fromPostalCode, $destPostalCode, $totalQuantity, $weight, $type, $cargo);
        } else {
            throw new HttpException(422, constants('exception_messages.no_mode'));
        }
        return response()->json($result);
    }

    private function calculateInternationalTariff(Request $request, $carriers, $lowestRate, $carrierWithLowestRateId, $carrierWithLowestRateName, $weight, $type, $cargo, $pickupIataCode, $destIataCode)
    {
        $date = $request->input('date');
        $measurements = $request->input('measurements');

        // Validate destIataCode
        $destinationExists = TariffDetail::where('destination_code', $destIataCode)->exists();
        if (!$destinationExists) {
            throw new HttpException(422, constants('exception_messages.dest'));
        }

        $usdConversion = Currency::where('code', 'CAD')->value('usd_per_unit');
        $airlineRates = [];
        $validTariffFound = false; // Flag to track if at least one valid tariff is found

        foreach ($carriers as $carrier) {
            foreach ($carrier->carrierTariffs as $tariff) {
                foreach ($tariff->tariffValidations as $tariffValidation) {
                    if ($tariffValidation->valid_at <= $date && $tariffValidation->expire_at >= $date) {
                        // At least one carrier has a valid tariff
                        $validTariffFound = true;

                        $measurementsValid = true;
                        foreach ($measurements as $key => $measurement) {
                            if ($tariffValidation->max_height < $measurement['height']) {
                                throw new HttpException(422, str_replace(['ROW'], $key + 1, constants('exception_messages.max_height') . $tariffValidation->max_height));
                            }
                            if ($tariffValidation->max_width < $measurement['width']) {
                                throw new HttpException(422, str_replace(['ROW'], $key + 1, constants('exception_messages.max_width') . $tariffValidation->max_width));
                            }
                            if ($tariffValidation->max_length < $measurement['length']) {
                                throw new HttpException(422, str_replace(['ROW'], $key + 1, constants('exception_messages.max_length') . $tariffValidation->max_length));
                            }
                        }

                        // If Measurement and Date Validations pass
                        if ($measurementsValid) {
                            $tariffDetail = TariffDetail::where('carrier_tariff_id', $tariff->id)
                                ->where('origin_code', $pickupIataCode)
                                ->where('destination_code', $destIataCode)
                                ->where('min_weight', '<=', $weight)
                                ->where('max_weight', '>=', $weight)
                                ->first();

                            if (!$tariffDetail) {
                                continue;
                            }

                            //calculation logic
                            $rate = ($tariffDetail->rate + $this->getCarrierCharges($carrier->id, 'surcharge')) * $weight;
                            $rate += $this->getCarrierCharges($carrier->id, 'airable_fee');
                            $rate += $lowestRate;
                            $rate += $this->getCarrierCharges($carrierWithLowestRateId, 'bonded_charges');
                            $rate /= $usdConversion;
                            $rate += $this->getCarrierCharges($carrier->id, 'custom_charges');
                            $rate += getTariffProfit($weight);
                            $rate_per_kg = $rate / $weight;

                            // Calculate base rate
                            $base_rate = $tariffDetail->rate + $this->getCarrierCharges($carrier->id, 'surcharge');
                            $base_rate *= $weight;

                            // Add additional charges
                            $base_rate += $this->getCarrierCharges($carrier->id, 'airable_fee');
                            $base_rate += $lowestRate;
                            $base_rate += $this->getCarrierCharges($carrierWithLowestRateId, 'bonded_charges');
                            $base_rate /= $usdConversion;
                            $base_rate += $this->getCarrierCharges($carrier->id, 'custom_charges');

                            // Calculate rate per kg without profit
                            $rate_per_kg_without_profit = $base_rate / $weight;

                            // Calculate rate with profit
                            $profit = getTariffProfit($weight);
                            $rate_with_profit = $base_rate + $profit;
                            $rate_per_kg_with_profit = $rate_with_profit / $weight;

                            $rate_without_profit = number_format($rate_per_kg_without_profit, 2, '.', '');
                            $formattedRate = number_format($rate_with_profit, 2, '.', '');
                            $formattedRatePerKg = number_format($rate_per_kg_with_profit, 2, '.', '');
                            // Iterate over carrier days
                            $airlineRates[] = [
                                'carrier_id' => $carrier->id,
                                'logo' => $carrier->logo,
                                'carrier_name' => $carrier->carrier_name,
                                'carrier_code' => $carrier->carrier,
                                'carrier_tariff_rate' => $tariffDetail->rate,
                                'weight_in_kg' => $weight,
                                'carrier_surcharge' => $this->getCarrierCharges($carrier->id, 'surcharge'),
                                'carrier_airable_fee' => $this->getCarrierCharges($carrier->id, 'airable_fee'),
                                'carrier_bonded_charges' => $this->getCarrierCharges($carrierWithLowestRateId, 'bonded_charges'),
                                'carrier_custom_charges' => $this->getCarrierCharges($carrier->id, 'custom_charges'),
                                'pickup_charge' => $lowestRate,
                                'pickup_carrier_name' => $carrierWithLowestRateName,
                                'profit' => getTariffProfit($weight),
                                'rate_per_kg' => $formattedRatePerKg,
                                'total_rate' => $formattedRate,
                                'zero_profit_rate' => $rate_without_profit,
                                'origin' => $pickupIataCode,
                                'dest' => $destIataCode,
                                // 'day' => $dayName,
                                'type' => $cargo,
                                'cargo_type' => $type,
                            ];
                        }
                    }
                }
            }
        }

        // If at least one valid tariff is found, return the airlineRates
        if ($validTariffFound) {
            return $airlineRates;
        } else {
            // If no valid tariff is found for any carrier, throw an exception
            throw new HttpException(422, constants('exception_messages.no_valid_tariff'));
        }
    }


    private function calculateLocalTariff(Request $request, $truckingCarriers, $fromPostalCode, $destPostalCode, $totalQuantity, $weight, $type, $cargo)
    {
        $date = $request->input('date');
        $measurements = $request->input('measurements');
        $insidePickup = $request->input('Inside_Pickup', 'N');
        $residentialPickup = $request->input('Residential_Pickup', 'N');
        $lifgatePickup = $request->input('Lifgate_Pickup', 'N');
        $lifgateDelivery = $request->input('Lifgate_Pickup', 'N');
        $doNotStack = $request->input('Do_Not_Stack', 'N');

        $weightLbs = convertWeightToLbs($weight);
        $toPostalCode = $destPostalCode;

        $validatedResults = $this->validateMeasurements($truckingCarriers, $measurements);
        $validatedCarrierData = $validatedResults['validatedCarrierData'];

        $polarisRate = null;
        $ensureFreightRate = null;

        foreach ($validatedCarrierData as $carrierData) {
            if ($carrierData['name'] === 'Polaris Trucking') {
                // Calculate Polaris rate
                $polarisRate = $this->getPolarisCargoDeliveryCharge(
                    $fromPostalCode,
                    $toPostalCode,
                    $totalQuantity,
                    $date,
                    $weightLbs,
                    $insidePickup,
                    $residentialPickup,
                    $lifgatePickup,
                    $lifgateDelivery,
                    $doNotStack
                );
            } elseif ($carrierData['name'] === 'Ensure Freight Trucking') {
                // Calculate Ensure Freight rate
                $ensureFreightRate = $this->ensureFreightTrucking($weight, $measurements);
            }
        }

        if ($polarisRate === null && $ensureFreightRate === null) {
            throw new HttpException(422, constants('exception_messages.cargo_charge'));
        }

        $usdConversion = Currency::where('code', 'CAD')->value('usd_per_unit');
        $airlineRates = [];

        foreach ($validatedCarrierData as $carrierData) {

            if ($carrierData['name'] === 'Polaris Trucking') {
                $rate = $polarisRate;
            } elseif ($carrierData['name'] === 'Ensure Freight Trucking') {
                $rate = $ensureFreightRate;
            }

            if ($rate !== null) {
                // Convert rate to USD
                $rateUsd = $rate / $usdConversion;

                $formattedRate = number_format($rateUsd, 2, '.', '');
                $ratePerKg = $rateUsd / $weight; // Divide by weight after USD conversion
                $formattedRatePerKg = number_format($ratePerKg, 2, '.', '');

                // Add the rate information to $airlineRates array
                $airlineRates[] = [
                    'carrier_id' => $carrierData['id'] ?? null,
                    'logo' => $carrierData['logo'] ?? null,
                    'carrier_name' => $carrierData['name'],
                    'carrier_code' => $carrierData['carrier'] ?? null,
                    'carrier_tariff_rate' => $formattedRate,
                    'weight_in_kg' => $weight,
                    'carrier_bonded_charges' => null,
                    'carrier_surcharge' => null,
                    'carrier_airable_fee' => null,
                    'carrier_custom_charges' => null,
                    'zero_profit_rate' => null,
                    'profit' => getTariffProfit($weight),
                    'pickup_charge' => $formattedRate,
                    'pickup_carrier_name' => $carrierData['name'],
                    'rate_per_kg' => $formattedRatePerKg,
                    'total_rate' => $formattedRate,
                    'origin' => $fromPostalCode,
                    'dest' => $toPostalCode,
                    // 'day' => $dayName,
                    'type' => $cargo,
                    'cargo_type' => $type,
                ];
            }
        }

        return $airlineRates;
    }


    private function getCarrierCharges($carrierId, $slug)
    {
        $chargeType = ChargeType::where('slug', $slug)->first();
        $carrierCharge = CarrierCharge::where('carrier_id', $carrierId)
            ->where('charge_type_id', $chargeType->id)
            ->first();

        if ($carrierCharge === null) {
            throw new HttpException(422, constants('exception_messages.cargo_charge'));
        }

        return $carrierCharge->charges_amt;
    }

    private function getPolarisCargoDeliveryCharge(
        $fromPostalCode,
        $toPostalCode,
        $totalQuantity,
        $date,
        $weightLbs,
        $insidePickup,
        $residentialPickup,
        $lifgatePickup,
        $lifgateDelivery,
        $doNotStack
    ) {
        // Prepare the payload for the polaris API
        $payload = [
            "RATE_API" => [
                "From_PC_ZIP" => $fromPostalCode,
                "To_PC_ZIP" => $toPostalCode,
                "Class" => "",
                "Pickup_Date" => $date,
                "Total_Weight_lbs" => $weightLbs,
                "Number_of_Pieces" => "",
                "Description" => "TEST",
                "ShipInstructions" => [
                    "Inside_Pickup" => $insidePickup,
                    "Residential_Pickup" => $residentialPickup,
                    "Lifgate_Pickup" => $lifgatePickup,
                    "Inside_Delivery" => "N",
                    "Residential_Delivery" => "N",
                    "Lifgate_Delivery" => $lifgateDelivery,
                    "Appointment_Delivery" => "N",
                    "OverSizeFreight" => "N",
                    "LimitedAccess" => "N",
                    "Do_Not_Stack" => $doNotStack,
                ],
                "Number_of_Skids" => $totalQuantity,
                "SkidDimensions" => [
                    [
                        "Skid" => "3",
                        "Length" => "48",
                        "Width" => "48",
                        "Height" => "40",
                    ],
                ],
            ],
        ];

        $polarisApiResponse = $this->polarisApiService->getRates($payload);
        $cargoDeliveryCharge = $polarisApiResponse['Rate_API_Response']['Total_Charge'] ?? null;

        // if ($cargoDeliveryCharge === null) {
        //     throw new HttpException(422, constants('exception_messages.cargo_charge'));
        // }

        return $cargoDeliveryCharge;
    }

    private function ensureFreightTrucking($weight, $measurements)
    {
        $payload = [
            'weight' => $weight,
            'measurements' => $measurements,
        ];

        $response = Http::post(env('APP_URL') . '/api/trucking/charge', $payload);

        if ($response->successful()) {
            $charge = $response->json()['charge'];
        } else {
            $errorMessage = $response->json()['message'] ?? 'Failed to get charge from your Ensure Freight Trucking';
            throw new HttpException(422, $errorMessage);
        }

        // dd(number_format($charge, 2));
        return $charge;
    }

    private function checkMeasurements($measurements, $weightLbs, $weight)
    {

        foreach ($measurements as $key => $measurement) {

            if ($measurement['chargeable_weight'] > 1587 && $measurement['quantity'] == 1) {
                throw new HttpException(422, str_replace('[ROW]', $key + 1, constants('exception_messages.one_skid_over_weight_cargo')));
            }

            if ($weight > 12000) {
                throw new HttpException(422, constants('exception_messages.over_weight_cargo'));
            }

            if ($weightLbs < 220) {
                throw new HttpException(422, constants('exception_messages.under_weight_cargo'));
            }

            if ($measurement['chargeable_weight'] < 100) {
                throw new HttpException(422, str_replace('[ROW]', $key + 1, constants('exception_messages.under_weight_cargo')));
            }
        }
    }

    private function validateMeasurements($truckingCarriers, $measurements)
    {
        $validCarriers = [];
        $validatedCarrierData = [];

        foreach ($truckingCarriers as $carrier) {
            $passesValidation = true;
            $exceptionMessages = [];

            foreach ($carrier->carrierTariffs as $tariff) {
                if (!$tariff->tariffValidations) {
                    continue;
                }

                foreach ($measurements as $key => $measurement) {
                    foreach ($tariff->tariffValidations as $tariffValidation) {
                        if ($tariffValidation->max_height < $measurement['height']) {
                            $exceptionMessages[] = "Height exceeds maximum allowed for carrier {$carrier->name}: {$tariffValidation->max_height}";
                            $passesValidation = false;
                        }
                        if ($tariffValidation->max_width < $measurement['width']) {
                            $exceptionMessages[] = "Width exceeds maximum allowed for carrier {$carrier->name}: {$tariffValidation->max_width}";
                            $passesValidation = false;
                        }
                        if ($tariffValidation->max_length < $measurement['length']) {
                            $exceptionMessages[] = "Length exceeds maximum allowed for carrier {$carrier->name}: {$tariffValidation->max_length}";
                            $passesValidation = false;
                        }
                    }
                }
            }

            if ($passesValidation) {
                $validCarriers[] = $carrier;
                $validatedCarrierData[] = ['id' => $carrier->id, 'name' => $carrier->carrier_name, 'logo' => $carrier->logo, 'carrier' => $carrier->carrier];
            } else {
                throw new Exception(implode("\n", $exceptionMessages));
            }
        }

        return ['validCarriers' => $validCarriers, 'validatedCarrierData' => $validatedCarrierData];
    }

    private function getCarrierIdByName($validatedCarrierData, $carrierName)
    {
        foreach ($validatedCarrierData as $carrier) {
            if ($carrier['name'] === $carrierName) {
                return $carrier['id'];
            }
        }
        return null;
    }

    private function getLowestRateAndCarrierId($truckingCarriers, $measurements, $fromPostalCode, $toPostalCode, $totalQuantity, $date, $weightLbs, $weight, $insidePickup, $residentialPickup, $lifgatePickup, $lifgateDelivery, $doNotStack)
    {
        // Validate Measurements and Obtain Validated Carrier Data
        $validatedResults = $this->validateMeasurements($truckingCarriers, $measurements);
        $validatedCarrierData = $validatedResults['validatedCarrierData'];

        // Calculate both rates
        $polarisRate = $this->getPolarisCargoDeliveryCharge(
            $fromPostalCode,
            $toPostalCode,
            $totalQuantity,
            $date,
            $weightLbs,
            $insidePickup,
            $residentialPickup,
            $lifgatePickup,
            $lifgateDelivery,
            $doNotStack
        );
        $ensureFreightRate = $this->ensureFreightTrucking($weight, $measurements);

        // Ensure both rates are floats for accurate comparison
        $polarisRate = is_numeric($polarisRate) ? (float) $polarisRate : 0;
        $ensureFreightRate = is_numeric($ensureFreightRate) ? (float) $ensureFreightRate : 0;

        // If one rate is zero, set the other rate to the lowest non-zero rate
        if ($polarisRate == 0 && $ensureFreightRate !== 0) {
            $lowestRate = $ensureFreightRate;
            $carrierWithLowestRateName = 'Ensure Freight Trucking';
        } elseif ($ensureFreightRate == 0 && $polarisRate !== 0) {
            $lowestRate = $polarisRate;
            $carrierWithLowestRateName = 'Polaris Trucking';
        } else {
            // Both rates are non-zero, compare them
            if ($polarisRate < $ensureFreightRate) {
                $lowestRate = $polarisRate;
                $carrierWithLowestRateName = 'Polaris Trucking';
            } else {
                $lowestRate = $ensureFreightRate;
                $carrierWithLowestRateName = 'Ensure Freight Trucking';
            }
        }
        // Get the ID of the carrier with the lowest rate
        $carrierWithLowestRateId = $this->getCarrierIdByName($validatedCarrierData, $carrierWithLowestRateName);

        if ($lowestRate == null) {
            throw new HttpException(422, constants('exception_messages.cargo_charge'));
        }
        // Return the lowest rate, carrier ID, and carrier name
        return [
            'lowestRate' => number_format($lowestRate, 2), // Formatting the rate to two decimal places
            'carrierWithLowestRateId' => $carrierWithLowestRateId,
            'carrierWithLowestRateName' => $carrierWithLowestRateName,
        ];
    }
}
