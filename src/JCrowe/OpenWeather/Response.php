<?php namespace JCrowe\OpenWeather;

use Exception;
use GuzzleHttp\Message\ResponseInterface;

class Response {

    /** @var  ResponseInterface */
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getWeatherData()
    {
        try {
            $body = $this->getBody();

            if(isset($body['weather'][0])) {
                return $body['weather'][0];
            }

        } catch (Exception $e) { }

        return array();
    }

    public function getBody()
    {
        return $this->response->json();
    }

    public function isValid()
    {
        return $this->response->getStatusCode() == 200;
    }

}