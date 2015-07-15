<?php namespace JCrowe\OpenWeather;

use Exception;
use GuzzleHttp\Message\ResponseInterface;

class Response {

    /** @var  ResponseInterface */
    protected $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Parse out weather data from the response body
     *
     * @return array
     */
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


    /**
     * get the raw response body as json
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->response->json();
    }


    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->response->getStatusCode() == 200;
    }

}