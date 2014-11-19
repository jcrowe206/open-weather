<?php

use JCrowe\OpenWeather\ClientFactory;

class ClientFactoryTest extends PHPUnit_Framework_TestCase {

    /** @var  ClientFactory */
    protected $clientFactory;

    protected $baseUrl = 'http://api.openweathermap.org/data/2.5';

    protected $guzzleOpts = array(
        'timeout' => 3,
        'connect_timeout' => 3
    );

    public function setUp()
    {
        $this->clientFactory = new ClientFactory($this->baseUrl, $this->guzzleOpts);
    }

    public function testCreateClientHasCorrectBaseUrl()
    {
        $client = $this->clientFactory->createClient();

        $this->assertEquals($this->baseUrl, $client->getBaseUrl());
    }

    public function testCreateClientHasCorrectGuzzleOpts()
    {
        $client = $this->clientFactory->createClient();

        $this->assertEquals(3, $client->getDefaultOption('timeout'));
        $this->assertEquals(3, $client->getDefaultOption('connect_timeout'));
    }
}