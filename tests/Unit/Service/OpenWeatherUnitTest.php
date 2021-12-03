<?php

namespace App\Tests\Unit\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\OpenWeatherService;

class OpenWeatherUnitTest extends WebTestCase
{
    public function test_place_name_should_have_odd_number_of_letters(): void
    {
        $data_place1 = json_decode(file_get_contents("./tests/testfiles/Cairo_odd_name_temp_11_night.json"), true);

        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $this->assertTrue($service->isOdd($data_place1['name']));
    }

    public function test_place_is_currently_night_and_temperature_between_10_15()
    {
        $data_place1 = json_decode(file_get_contents("./tests/testfiles/Porto_odd_name_temp_11_night.json"), true);

        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $response = (!$service->isDay($data_place1)) && $service->isTemperatureBetween($data_place1['main']['temp'], 10, 15);

        $this->assertTrue($response);
    }

    public function test_place_is_currently_day_and_temperature_between_17_25()
    {
        $data_place1 = json_decode(file_get_contents("./tests/testfiles/Hamburg_odd_name_temp_19_day.json"), true);

        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $response = ($service->isDay($data_place1)) && $service->isTemperatureBetween($data_place1['main']['temp'], 17, 25);

        $this->assertTrue($response);
    }

    public function test_is_currently_warmer_than_location()
    {
        $data_place1 = json_decode(file_get_contents("./tests/testfiles/Brasilia_even_name_temp_25_night.json"), true);
        $data_place2 = json_decode(file_get_contents("./tests/testfiles/Köln_even_name_temp_9.4_night.json"), true);

        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $response = $service->isWarmerThan($data_place1['main']['temp'], $data_place2['main']['temp']);

        $this->assertTrue($response);
    }
}