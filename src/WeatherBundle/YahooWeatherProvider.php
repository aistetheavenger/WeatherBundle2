<?php

namespace Nfq\WeatherBundle;

class YahooWeatherProvider implements WeatherProviderInterface
{

    /**
     * {@inheritdoc}
     */
    public function fetch(Location $location): Weather
    {
        $lat = $location->getLat();
        $lon = $location->getLon();

        $baseUrl = 'http://query.yahooapis.com/v1/public/yql';
        $yql_query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text=\"($lat, $lon)\") and u=\"c\"";
        $yql_query_url = $baseUrl . "?q=" . _($yql_query) . "&format=json";

        $session = curl_init();
        curl_setopt_array($session, array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $yql_query_url,
        ));
        $result = curl_exec($session);
        curl_close($session);
        $phpObj = json_decode($result);
        if(!isset($phpObj->query->results->channel->item->condition->temp)){
            throw new WeatherProviderException('Error');
        }

        $temp = $phpObj->query->results->channel->item->condition->temp;

        return new Weather($temp);
    }
}