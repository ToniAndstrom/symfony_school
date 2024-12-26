<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService {
    private $httpClient;
    public function __construct(HttpClientInterface $httpClient)
      {
        $this->httpClient = $httpClient;
      }
      public function getTravelLocations(): array  {    $response = $this->httpClient->request("GET","https://restcountries.com/v3.1/all");return $response->toArray();  }}
