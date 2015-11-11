<?php namespace JCrowe\OpenWeather;

use GuzzleHttp\Exception\RequestException;


/**
 * Class OpenWeather
 * @package JCrowe\OpenWeather
 */
class OpenWeather {

    /** @var  Requester */
    protected $requester;

    /**
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }


    /**
     * Create an instance of the openweather object.
     *
     * @param $guzzleOpts
     * @param $baseUrl
     * @param $appId
     * @return OpenWeather
     * @throws InvalidArgumentException
     */
    public static function getInstance($guzzleOpts, $baseUrl, $appId)
    {
        $clientFactory = new ClientFactory($baseUrl, $guzzleOpts);
        $requester = new Requester($clientFactory, $appId);

        return new OpenWeather($requester);
    }

    /**
     * Get weather report for the provided $lat and $lng
     *
     * @param $lat
     * @param $long
     * @param string $unit
     * @param int $count
     * @return Response
     * @throws RequestException
     */
    public function get($lat, $long, $unit = 'imperial', $count = 1)
    {
        $params = array(
            'lat' => $lat,
            'lon' => $long,
            'units' => $unit,
            'cnt' => $count
        );

        return $this->requester->makeRequest($params);
    }

    /**
     * Get weather report for the provided $city name
     *
     * @param $city
     * @param string $country
     * @param string $unit
     * @return Response
     * @throws RequestException
     */
    public function getByCityName($city, $country = 'us', $unit = 'imperial')
    {
        $params = array(
            'q' => $city . ',' . $country,
            'units' => $unit
        );

        return $this->requester->makeRequest($params);
    }

}