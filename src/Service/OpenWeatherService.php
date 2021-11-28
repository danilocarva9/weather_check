<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class OpenWeatherService implements OpenWeatherServiceInterface
{
    
    private $baseUrl;
    private $apiKey;
    private $apiUnit;
    private $preLocation;
    private $httpClient;

    public function __construct(string $baseUrl, string $apiKey, string $apiUnit, string $preLocation, HttpClientInterface  $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->apiUnit = $apiUnit;
        $this->preLocation = $preLocation;
        $this->httpClient = $httpClient;
    }

    public function fetchOne(string $city)
    {
        $city_forecast = $this->parseWeatherCity($this->fetchWeatherCity($city));
        return $city_forecast;
    }

    private function fetchWeatherCity(string $city): array
    {
        $response  = $this->httpClient->request('GET', $this->baseUrl,[
            'headers' => [
            'Accept' => 'application/json',
            ],
            'query'   => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => $this->apiUnit
            ]
        ]);

        if ($response->getStatusCode() == 404) {
            throw new NotFoundHttpException();
        } elseif ($response->getStatusCode() != 200) {
            throw new ServiceUnavailableHttpException();
        }

        return $response->toArray();
    }

    private function parseWeatherCity(array $city): array
    {

        //dd($city);
        $result = [];
        $check = false;
        $naming = false;
        $daytemp = false;
        $rival = false;

        // echo $this->isDay($city);
       
        //  echo "<br/>";
        // $timestamp= $city['dt'];
        // echo 'dt: '.gmdate("Y-m-d  H:i:s", $timestamp);
        // echo "<br/>";
        // $timestamp= $city['sys']['sunrise'];
        // echo 'sunrise: '.gmdate("Y-m-d  H:i:s", $timestamp);
        // echo "<br/>";
        // $timestamp= $city['sys']['sunset'];
        // echo 'sunset: '.gmdate("Y-m-d  H:i:s", $timestamp);
        // exit;
      
        if($this->isOdd(strlen(utf8_decode($city['name'])))){
           $naming = true;
           $check = true;
        }

        if((!$this->isDay($city) and $this->isTemperatureBetween($city['main']['temp'], 10, 15)) or 
        ($this->isDay($city) and $this->isTemperatureBetween($city['main']['temp'], 17, 25))){
            $daytemp = true;
            $check = true;
        }

        if($this->isWarmerThan($city['main']['temp'], $this->fetchWeatherCity($this->preLocation)['main']['temp'])){
            $rival = true;
            $check = true;
        }

        $result = [
            'check' => $check,
            'criteria' => ['naming' => $naming, 'daytemp' => $daytemp, 'rival' => $rival],
            'data' => $city
        ];

        return $result;
    }

    function isOdd($num): bool
    {
        return (is_int($num) && abs($num % 2) == 1) ? true : false;
    }

    function isDay($data)
    {
        return ((gmdate("Y-m-d H:i:s", $data['dt']) > gmdate("Y-m-d H:i:s", $data['sys']['sunrise'])) &&
        gmdate("Y-m-d H:i:s", $data['dt']) < gmdate("Y-m-d H:i:s", $data['sys']['sunset'])) ? true : false;
    }

    function isTemperatureBetween($current_temp, $temp1, $temp2): bool 
    {
       return ($current_temp > $temp1) && ($current_temp < $temp2) ? true : false;
    }

    function isWarmerThan($current_temp, $location_temp): bool 
    {
        return ($current_temp > $location_temp) ? true : false;
    }
}
