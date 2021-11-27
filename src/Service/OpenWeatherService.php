<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherService extends AbstractOpenWeatherService
{

    private $baseUrl;
    private HttpClientInterface $httpClient;

    //private const URL = 'http://api.openweathermap.org/data/2.5/weather?q=D%C3%BCsselsdorf,de&appid=8ca1bf554fe26dff41d635d4e2f866ed';

    public function __construct(string $baseUrl, HttpClientInterface  $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
    }


    public function fetchData(string $location): string
    {
        
        $response  = $this->httpClient->request('GET', $this->baseUrl,[
            'headers' => [
            'Accept' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            //return new JsonResponse('Finance API Client Error ', 400);
            return throw new \Exception();
        }

        return json_decode($response->getContent());

        
        // $httpClient = HttpClient::create();
        // //$response = $httpClient->request('GET', 'http://api.openweathermap.org/data/2.5/weather?q=D%C3%BCsseldorf,de&appid=8ca1bf554fe26dff41d635d4e2f866ed');

        // $response = $httpClient->request('GET', 'http://api.openweathermap.org/data/2.5/weather?q=D%C3%BCsseldorf,de&appid=8ca1bf554fe26dff41d635d4e2f866ed', [
        //     'headers' => [
        //         'Accept' => 'application/json',
        //     ],
        // ]);


        // if (200 !== $response->getStatusCode()) {
        //     // handle the HTTP request error (e.g. retry the request)
        //     throw new \Exception();
        // } else {
        //     $content = $response->getContent();
        // }

        // return $content;

    }
}
