<?php
namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class ApiClient
{

    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    private function fetch(string $url, array $body): array
    {
        $response  = $this->httpClient->request('GET', $url,[
            'headers' => [
            'Accept' => 'application/json',
            ],
            $body
        ]);

        if ($response->getStatusCode() == 404) {
            throw new NotFoundHttpException();
        } elseif ($response->getStatusCode() != 200) {
            throw new ServiceUnavailableHttpException();
        }

        return $response->toArray();
    }
}
