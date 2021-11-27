<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherService implements OpenWeatherServiceInterface
{
    
    private $baseUrl;
    private $apiKey;
    private $apiUnit;
    private HttpClientInterface $httpClient;

    public function __construct(string $baseUrl, string $apiKey, string $apiUnit, HttpClientInterface  $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->apiUnit = $apiUnit;
        $this->httpClient = $httpClient;
    }

    public function fetchData($request)
    {
        $response  = $this->httpClient->request('GET', $this->baseUrl,[
            'headers' => [
            'Accept' => 'application/json',
            ],
            'query'   => [
                'q' => $request->query->get('q'),
                'appid' => $this->apiKey,
                'units' => $this->apiUnit
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            //return new JsonResponse('API Client Error ', 400);
            return throw new \Exception();
        }

        $fetchedData = json_decode($response->getContent());

        //Devo colocar a regra de ngócio aqui, anter de retornar para o Controller?
        
        //Devo colocar a regra de ngócio aqui, anter de retornar para o Controller?
        return $fetchedData;
    }
}
