<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\OpenWeatherService;

class MainController extends AbstractController
{
    protected $openWeatherService;
    
    public function __construct(OpenWeatherService $openWeatherService)
    {
        $this->openWeatherService = $openWeatherService;
    }

    #[Route('/check', name: 'check')]
    public function check(Request $request): Response
    {
        try {
            $response = $this->openWeatherService->fetchOne($request->query->get('q'));
            return new JsonResponse($response, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => true], Response::HTTP_NOT_FOUND);
        }
    }
}
