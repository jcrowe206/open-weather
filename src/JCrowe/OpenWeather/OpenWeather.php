<?php namespace JCrowe\OpenWeather;

class OpenWeather {

    /** @var  Requester */
    protected $requester;

    private $API = array(
        'endpoints' => array(
            'get_weather' => array('uri' => 'weather', 'method' => 'GET'),
        ),
    );

    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    public static function getInstance($guzzleOpts, $baseUrl)
    {
        $clientFactory = new ClientFactory($baseUrl, $guzzleOpts);
        $requester = new Requester($clientFactory);

        return new OpenWeather($requester);
    }

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

    public function getByCityName($city, $country = 'us', $unit = 'imperial')
    {
        $params = array(
            'q' => $city . ',' . $country,
            'units' => $unit
        );

        return $this->requester->makeRequest($params);
    }

}