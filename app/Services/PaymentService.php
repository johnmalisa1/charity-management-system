<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.stakaba.base_url');
        $this->apiKey  = config('services.stakaba.key');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10,
        ]);
    }

    /**
     * Initiate a mobile money payment (sandbox).
     */
    public function initiatePayment($amount, $currency, $mobileNumber, $network)
    {
        try {
            $response = $this->client->post('/api/v1/payments/collection', [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'Accept'    => 'application/json',
                ],
                'json' => [
                    'grossAmount'  => $amount,
                    'currency'     => $currency,
                    'mobileNumber' => $mobileNumber,
                    'network'      => $network, // e.g. "Mpesa", "Airtel", "Halopesa"
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Stakaba Payment Error: '.$e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
