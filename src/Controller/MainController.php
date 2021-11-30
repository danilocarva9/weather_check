<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OpenWeatherService;

class MainController extends AbstractController
{
    protected $openWeatherService;
    
    public function __construct(OpenWeatherService $openWeatherService)
    {
        $this->openWeatherService = $openWeatherService;
    }

    //#[Route('/check', name: 'check')] - newer way

    /**
     * Matches /check exactly
     *
     * @Route("/check", name="check")
     */

    public function check(Request $request): Response
    {
        $response = $this->openWeatherService->fetchOne($request->query->get('q'));
        return $this->json($response);
    }
}
