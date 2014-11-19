<?php

use JCrowe\OpenWeather\Response;
use Mockery as m;
use Mockery\Mock;

class ResponseTest extends PHPUnit_Framework_TestCase {

    /** @var  Response */
    protected $response;

    /** @var  Mock */
    protected $mockGuzzleResponse;

    public function setUp()
    {
        $this->mockGuzzleResponse = m::mock('GuzzleHttp\Message\ResponseInterface');

        $this->response = new Response($this->mockGuzzleResponse);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testIsValidTrue()
    {
        $this->setStatusCode(200);

        $this->assertTrue($this->response->isValid());
    }

    public function testIsValidFalse()
    {
        $this->setStatusCode(400);

        $this->assertFalse($this->response->isValid());
    }

    public function testGetBody()
    {
        $this->mockGuzzleResponse->shouldReceive('json')
            ->once();

        $this->response->getBody();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetBodyException()
    {
        $this->mockGuzzleResponse->shouldReceive('json')
            ->once()->andThrow('\RuntimeException');

        $this->response->getBody();
    }

    public function testGetWeatherDataError()
    {
        $this->mockGuzzleResponse->shouldReceive('json')
            ->once()->andThrow('\RuntimeException');

        $this->assertEmpty($this->response->getWeatherData());
    }

    public function testGetWeatherDataSuccess()
    {
        $this->mockGuzzleResponse->shouldReceive('json')
            ->once()->andReturn(array(
                'weather' => array(
                    array(
                        'id' => 802,
                        'main' => 'Clouds',
                        'description' => 'scattered clouds',
                        'icon' => '03n'
                    )
                )
            ));

        $weather = $this->response->getWeatherData();

        $this->assertCount(4, $weather);
        $this->assertEquals('Clouds', $weather['main']);
    }

    public function testGetWeatherDataIncorrectJson()
    {
        $this->mockGuzzleResponse->shouldReceive('json')
            ->once()->andReturn(array(
                'weather' => array(
                    'id' => 802,
                    'main' => 'Clouds',
                    'description' => 'scattered clouds',
                    'icon' => '03n'
                )
            ));

        $this->assertEmpty($this->response->getWeatherData());
    }
    private function setStatusCode($code)
    {
        $this->mockGuzzleResponse->shouldReceive('getStatusCode')
            ->once()->andReturn($code);
    }

} 