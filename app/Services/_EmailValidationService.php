<?php

namespace App\Services;

use GuzzleHttp\Client;

class EmailValidationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('ABSTRACT_API_KEY'); // Ambil API key dari .env
    }

    public function validateEmail($email)
    {
        // Kirim request ke Abstract API
        $response = $this->client->get('https://emailvalidation.abstractapi.com/v1/', [
            'query' => [
                'api_key' => $this->apiKey,
                'email' => $email,
            ],
        ]);

        // Decode respons JSON
        return json_decode($response->getBody(), true);
    }
}