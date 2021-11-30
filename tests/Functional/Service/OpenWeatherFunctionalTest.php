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

        $client = static::createClient();
     
        // Start mocking
        // $container = self::getContainer();
        // $openWeatherService = $this->getMockBuilder(OpenWeatherService::class)
        // ->disableOriginalConstructor()
        // ->onlyMethods(['fetchOne'])
        // ->getMock();
        // $openWeatherService->method('fetchOne')->willThrowException(new \Exception());
        // $container->set('App\Service\OpenWeatherService', $openWeatherService);
        // End mocking

        $client->request('GET', '/check', ['q' => 'Madrid']);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
         //$this->assertResponseIsSuccessful();
    }
   
}