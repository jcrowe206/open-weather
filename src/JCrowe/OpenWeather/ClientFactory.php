<?php namespace JCrowe\OpenWeather;

use GuzzleHttp\Client;

class ClientFactory {

    /** @var  string */
    protected $baseUrl;

    /** @var  array */
    protected $guzzleOpts;

    public function __construct($baseUrl, array $guzzleOpts = array())
    {
        $this->baseUrl = $baseUrl;
        $this->guzzleOpts = $guzzleOpts;
    }

    public function createClient()
    {
        $config = array(
            'base_url' => $this->baseUrl,
            'defaults' => $this->guzzleOpts
        );

        return new Client($config);
    }

}