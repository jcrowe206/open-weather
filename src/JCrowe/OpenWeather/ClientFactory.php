<?php namespace JCrowe\OpenWeather;

use GuzzleHttp\Client;

/**
 * Factory to create guzzle client
 *
 * Class ClientFactory
 * @package JCrowe\OpenWeather
 */
class ClientFactory {

    /** @var  string */
    protected $baseUrl;

    /** @var  array */
    protected $guzzleOpts;


    /**
     * @param $baseUrl
     * @param array $guzzleOpts
     */
    public function __construct($baseUrl, array $guzzleOpts = array())
    {
        $this->baseUrl = $baseUrl;
        $this->guzzleOpts = $guzzleOpts;
    }


    /**
     * Create a guzzle client using the configured options
     *
     * @return Client
     */
    public function createClient()
    {
        $config = array(
            'base_url' => $this->baseUrl,
            'defaults' => $this->guzzleOpts
        );

        return new Client($config);
    }

}