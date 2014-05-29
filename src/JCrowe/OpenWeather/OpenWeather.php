<?php namespace JCrowe\OpenWeather;

class OpenWeather {

    private $config = array(
        'curl_connecttimeout' => 30,
        'curl_timeout' => 30,
    );

    private $API = array(
        'version' => '2.5',
        'base_url' => 'http://api.openweathermap.org/data/',

        'endpoints' => array(
            'get_weather' => array('uri' => 'weather', 'method' => 'GET'),
        ),
    );

    public function __construct() {

    }

    private function _constructURL($endpoint) {
        return $this->API['base_url'] . $this->API['version'] . '/' . $this->API['endpoints'][$endpoint]['uri'];
    }

    private function _getMethod($endpoint) {
        return $this->API['endpoints'][$endpoint]['method'];
    }

    private function _createQueryString(array $arr) {
        $str = '';
        foreach ($arr as $key => $val) {
            $str .= $key . '=' . urlencode($val) . '&';
        }

        return $str;
    }


    private function _call($endpoint, $params = array()) {
        $url = $this->_constructURL($endpoint);
        $method = $this->_getMethod($endpoint);

        $ch = curl_init();

        switch ($method) {
            case 'GET':
                $url = $url . '?' . $this->_createQueryString($params);
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params);
                break;
        }

        curl_setopt_array($ch, array(
            CURLOPT_CONNECTTIMEOUT => $this->config['curl_connecttimeout'],
            CURLOPT_TIMEOUT        => $this->config['curl_timeout'],
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

    public static function get($lat, $long, $unit = 'imperial', $count = 1) {
        $ow = new OpenWeather();
        return $ow->getWeather($lat, $long, $unit, $count);
    }

}