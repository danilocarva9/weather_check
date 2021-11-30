<?php

namespace App\Tests\Unit\Service;
//use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\OpenWeatherService;

class OpenWeatherUnitTest extends WebTestCase
{
    public function test_place_name_should_have_odd_number_of_letters(): void
    {
        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $this->assertTrue($service->isOdd('Cairo'));
    }

    // public function test_place_is_currently_night_and_temperature_between()
    // {
    //      $this->assertTrue(true);
    // }

    // public function test_place_is_currently_day_and_temperature_between()
    // {
    //      $this->assertTrue(true);
    // }

    // public function test_is_currently_warmer_than_location()
    // {
    //      $this->assertTrue(false);
    // }
}