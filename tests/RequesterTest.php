<?php

use JCrowe\OpenWeather\Requester;
use JCrowe\OpenWeather\Response;
use Mockery as m;
use Mockery\Mock;

class RequesterTest extends PHPUnit_Framework_TestCase {

    /** @var  Requester */
    protected $requester;

    /** @var  mock */
    protected $mockClientFactory;

    /** @var  mock */
    protected $mockClient;

    protected $appId = 'testOpenWeatherAppId';

    public function setUp()
    {
        $this->mockClient = m::mock('GuzzleHttp\Client');

        $this->mockClientFactory = m::mock('JCrowe\OpenWeather\ClientFactory');
        $this->mockClientFactory->shouldReceive('createClient')
            ->andReturn($this->mockClient);

        $this->requester = new Requester($this->mockClientFactory, $this->appId);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testCallCreatesResponse()
    {
        $testOpts = array();

        $this->mockClient->shouldReceive('get')
            ->with('/data/2.5/weather', $testOpts)->once()
            ->andReturn($this->getMockResponseInterface());

        $response = $this->requester->call($testOpts, '/data/2.5/weather');

        $this->assertInstanceOf('JCrowe\OpenWeather\Response', $response);
    }

    public function testMakeRequest()
    {
        $queryParams = array(
            'key' => 'value',
            'APPID' => $this->appId,
        );

        $testOpts = array('query' => $queryParams);

        $this->mockClient->shouldReceive('get')
            ->with('/data/2.5/weather', $testOpts)->once()
            ->andReturn($this->getMockResponseInterface());

        $response = $this->requester->makeRequest($queryParams);

        $this->assertInstanceOf('JCrowe\OpenWeather\Response', $response);
    }


    private function getMockResponseInterface()
    {
        $mockResponseInterface = m::mock('GuzzleHttp\Message\ResponseInterface');

        return $mockResponseInterface;
    }

} 