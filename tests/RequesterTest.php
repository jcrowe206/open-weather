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

    public function setUp()
    {
        $this->mockClient = m::mock('GuzzleHttp\Client');

        $this->mockClientFactory = m::mock('JCrowe\OpenWeather\ClientFactory');
        $this->mockClientFactory->shouldReceive('createClient')
            ->andReturn($this->mockClient);

        $this->requester = new Requester($this->mockClientFactory);
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

        $response = $this->requester->call($testOpts);

        $this->assertInstanceOf('JCrowe\OpenWeather\Response', $response);
    }

    public function testMakeRequest()
    {
        $requester = m::mock('JCrowe\OpenWeather\Requester')->makePartial();

        $queryParams = array(
            'key' => 'value'
        );

        $mockResponse = new Response($this->getMockResponseInterface());

        $requester->shouldReceive('call')->once()
            ->with(array('query' => $queryParams))
            ->andReturn($mockResponse);

        $response = $requester->makeRequest($queryParams);

        $this->assertInstanceOf('JCrowe\OpenWeather\Response', $response);
    }


    private function getMockResponseInterface()
    {
        $mockResponseInterface = m::mock('GuzzleHttp\Message\ResponseInterface');

        return $mockResponseInterface;
    }

} 