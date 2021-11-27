<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractOpenWeatherService
{

    private $baseUrl;
    private $httpClient;
  
    public function __construct(string $baseUrl, HttpClientInterface  $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
    }

    abstract protected function fetchData(string $location): string;

}
