<?php namespace JCrowe\OpenWeather;


use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;

class Requester {

    /** @var  Client */
    protected $client;

    protected $config;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->createClient();
    }

    public function makeRequest($queryParams)
    {
        $url = (isset($queryParams['cnt']) && $queryParams['cnt'] > 1) ? 'data/2.5/forecast/daily' : '/data/2.5/weather';

        $opts = array(
            'query' => $queryParams
        );

        return $this->call($opts, $url);
    }

    public function call(array $opts, $url)
    {
        /** @var ResponseInterface $response */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $response = $this->client->get($url, $opts);

        return new Response($response);
    }
}