<?php

namespace App\Service;

interface OpenWeatherServiceInterface
{
    public function fetchOne(string $city);
}
