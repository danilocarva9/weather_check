<?php

namespace App\Tests\Functional\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OpenWeatherService;

class OpenWeatherFunctionalTest extends WebTestCase
{

    public function test_it_returns_200_if_place_exists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/check', ['q' => 'Madrid']);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function test_it_returns_all_criterias_true(): void
    {
        $data_place1 = json_decode(file_get_contents("./tests/testfiles/Cairo_odd_name_temp_11_night.json"), true);

        $container = self::getContainer();
        $service = $container->get(OpenWeatherService::class);
        $response = $service->parseWeatherCity($data_place1);
        
        $this->assertTrue($response['check']);
        $this->assertTrue($response['criteria']['naming']);
        $this->assertTrue($response['criteria']['daytemp']);
        $this->assertTrue($response['criteria']['rival']);
    }
   
}