<?php

use JCrowe\OpenWeather\OpenWeather;
use Mockery as m;
use Mockery\Mock;

class OpenWeatherTest extends PHPUnit_Framework_TestCase {

    /** @var  OpenWeather */
    protected $openWeather;

    /** @var  Mock */
    protected $mockRequester;

    protected $baseUrl = 'http://api.openweathermap.org/';

    protected $guzzleOpts = array(
        'timeout' => 3,
        'connect_timeout' => 3
    );

    protected $appId = 'testOpenWeatherAppId';

    public function setUp()
    {
        $this->mockRequester = m::mock('JCrowe\OpenWeather\Requester');

        $this->openWeather = new OpenWeather($this->mockRequester);
    }

    public function testGetInstance()
    {
        $openWeather = OpenWeather::getInstance($this->guzzleOpts, $this->baseUrl, $this->appId);

        $this->assertInstanceOf('JCrowe\OpenWeather\OpenWeather', $openWeather);
    }

    public function testGetByLatLong()
    {
        $lat = '12.3';
        $long = '45.6';

        $this->mockRequester->shouldReceive('makeRequest')
            ->once()->with(array(
                'lat' => $lat,
                'lon' => $long,
                'units' => 'imperial',
                'cnt' => 1
            ));

        $this->openWeather->get($lat, $long);
    }

    public function testGetByCityName()
    {
        $city = 'los angeles';

        $this->mockRequester->shouldReceive('makeRequest')
            ->once()->with(array(
                'q' => 'los angeles,us',
                'units' => 'imperial'
            ));

        $this->openWeather->getByCityName($city);
    }


    /**
     * Here in case you want to actually test the Open Weather API
     */
    public function ActuallyTestWeather()
    {
        $openWeather = OpenWeather::getInstance($this->guzzleOpts, $this->baseUrl, $this->appId);

        $response = $openWeather->getByCityName('los angeles');
        $this->assertTrue($response->isValid());
    }


    /**
     * Here in case you want to actually test the Open Weather API
     * @expectedException InvalidArgumentException
     */
    public function testWeatherNoAppId()
    {
        $openWeather = OpenWeather::getInstance($this->guzzleOpts, $this->baseUrl, null);
    }

} 