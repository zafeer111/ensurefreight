<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PolarisApiService
{
    protected $polarisUrl;
    protected $apiKey;

    public function __construct($polarisUrl, $apiKey)
    {
        $this->polarisUrl = $polarisUrl;
        $this->apiKey = $apiKey;
    }

    public function getRates($payload)
    {
        $urlWithApiKey = $this->polarisUrl . '?APIKey=' . $this->apiKey;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($urlWithApiKey, $payload);

        if ($response->successful()) {
            return $response->json();
        } 
        // else {
        //     $responseBody = $response->json();

        //     if (isset($responseBody['Rate_API_Response']['Message'])) {
        //         $errorMessage = $responseBody['Rate_API_Response']['Message'];
        //     } else {
        //         $errorMessage = 'Failed to retrieve rates from the Polaris API. ';
        //     }

        //     Log::error('Polaris API Error: ' . $errorMessage, [
        //         'payload' => $payload,
        //         'response_body' => $response->body(),
        //     ]);
            
        //     throw new \Exception($errorMessage, 500);
        // }
    }
}