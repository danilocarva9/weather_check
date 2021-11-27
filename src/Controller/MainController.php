<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OpenWeatherService;

class MainController extends AbstractController
{
    
    public function __construct(OpenWeatherService $openWeatherService)
    {
        $this->openWeatherService = $openWeatherService;
    }

    #[Route('/check', name: 'check')]
    public function check(string $location): Response
    {
        $response = $this->openWeatherService->fetchData();
        //return $this->json($response);
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/MainController.php',
        // ]);
        
        return $this->json([
            'check' => false,
            'criteria' => ['naming'=>true, 'daytemp'=>false, 'rival'=>true],
            'data' => $response
        ]);

    }
}
