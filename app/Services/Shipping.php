<?php

namespace App\Services;

use GuzzleHttp\Client;

class Shipping {

    public static $url = "https://shipping-options-api.herokuapp.com/v1/shipping_options";

    public static function getShippingOptions()
    {
        $client = new Client();
        $response = $client->get(self::$url);
        $response = collect(json_decode($response->getBody(), true));
        $options = self::orderOptions($response->flatten(1)->toArray());

        return collect($options);
    }

    public static function orderOptions($options)
    {
        usort($options, function ($a, $b) {
            return ($a['cost'] > $b['cost'] || ($a['cost'] == $b['cost'] && $a['estimated_days'] > $b['estimated_days'] ) ? 1 : -1);
        });
        return $options;
    }

}
