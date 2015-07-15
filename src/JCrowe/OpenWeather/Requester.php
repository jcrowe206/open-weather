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
        $opts = array(
            'query' => $queryParams
        );

        return $this->call($opts);
    }


    /**
     * Execute the get method on the guzzle client and create a response
     *
     * @param array $opts
     * @return Response
     */
    public function call(array $opts)
    {
        /** @var ResponseInterface $response */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $response = $this->client->get('/data/2.5/weather', $opts);

        return new Response($response);
    }

}