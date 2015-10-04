<?php namespace JCrowe\OpenWeather;


use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;

class Requester {

    /** @var  Client */
    protected $client;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param ClientFactory $clientFactory
     */
    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->createClient();
    }

    /**
     * Make the http request
     *
     * @param $queryParams
     * @return Response
     */
    public function makeRequest($queryParams)
    {
        $url = (isset($queryParams['cnt']) && $queryParams['cnt'] > 1) ? 'data/2.5/forecast/daily' : '/data/2.5/weather';

        $opts = array(
            'query' => $queryParams
        );

        return $this->call($opts, $url);
    }


    /**
     * Execute the get method on the guzzle client and create a response
     *
     * @param array $opts
     * @return Response
     */
    public function call(array $opts, $url)
    {
        /** @var ResponseInterface $response */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $response = $this->client->get($url, $opts);

        return new Response($response);
    }
}