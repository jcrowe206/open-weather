<?php namespace JCrowe\OpenWeather;

use Illuminate\Contracts\Foundation\Application;

class OpenWeather {

    /** @var Application */
    protected $app;

    private $API = array(
        'version' => '2.5',
        'base_url' => 'http://api.openweathermap.org/data/',

        'endpoints' => array(
            'get_weather' => array('uri' => 'weather', 'method' => 'GET'),
        ),
    );

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function constructURL($endpoint) {
        return $this->API['base_url'] . $this->API['version'] . '/' . $this->API['endpoints'][$endpoint]['uri'];
    }

    public function getMethod($endpoint) {
        return $this->API['endpoints'][$endpoint]['method'];
    }

    public function createQueryString(array $arr) {
        $str = '';
        foreach ($arr as $key => $val) {
            $str .= $key . '=' . urlencode($val) . '&';
        }

        return $str;
    }


    private function _call($endpoint, $params = array()) {
        $url = $this->constructURL($endpoint);
        $method = $this->getMethod($endpoint);

        $ch = curl_init();

        switch ($method) {
            case 'GET':
                $url = $url . '?' . $this->createQueryString($params);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params);
                break;
        }

        curl_setopt_array($ch, array(
            CURLOPT_CONNECTTIMEOUT => $this->app->make('config')->get('OpenWeather::curl.connect_timeout'),
            CURLOPT_TIMEOUT        => $this->app->make('config')->get('OpenWeather::curl.request_timeout'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
        ));

        // do it!
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        return new OpenWeatherResponse($response, $code, $info, $error);
    }

    public function getWeather($lat, $long, $unit, $count) {
        return $this->_call('get_weather', array('lat' => $lat, 'lon' => $long, 'units' => $unit, 'cnt' => $count));
    }

    public function get($lat, $long, $unit = 'imperial', $count = 1)
    {
        return $this->getWeather($lat, $long, $unit, $count);
    }

    public function getByCityName($queryString, $unit = 'imperial')
    {
        return $this->_call('get_weather', array(
            'q' => $queryString,
            'units' => $unit,
        ));
    }

}