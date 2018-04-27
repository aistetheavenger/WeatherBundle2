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
        $yql_query_url = "http://api.openweathermap.org/data/2.5/weather?lat=".$location->getLat()."&lon=".$location->getLon()."&units=metric&appid=".$this->apiKey;
        $session = curl_init();
        curl_setopt_array($session, array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $yql_query_url,
        ));
        $result = curl_exec($session);
        curl_close($session);
        $phpObj = json_decode($result);
        if(!isset($phpObj->main->temp)){
            throw new WeatherProviderException('Error');
        }

        return new Weather($phpObj->main->temp);
    }
}