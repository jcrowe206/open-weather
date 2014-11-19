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
        $opts = array(
            'query' => $queryParams
        );

        return $this->call($opts);
    }

    public function call(array $opts)
    {
        /** @var ResponseInterface $response */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $response = $this->client->get('/data/2.5/weather', $opts);

        return new Response($response);
    }

}