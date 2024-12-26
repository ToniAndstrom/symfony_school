<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    private $httpClient;

    public function __construct(HttpClientInterface $client)
    {
        $this->httpClient = $client;
    }

    public function getRacesIn2024(): array
    {
        $response = $this->httpClient->request("GET", "https://ergast.com/api/f1/2024.json");
        return $response->toArray();
    }
}
