<?php

namespace Nfq\WeatherBundle;

class OpenWeatherMapWeatherProvider implements WeatherProviderInterface
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(Location $location): Weather
    {
        // TODO: Implement this
        return new Weather(24.1);
    }
}
