<?php

return array(

    /**
     * Options for GuzzleClient
     * @see http://guzzle.readthedocs.org/en/latest/clients.html#request-options
     * Note: exact names required here
     */
    'options' => array(
        'timeout' => 3,
        'connect_timeout' => 3
    ),

    'base_url' => 'http://api.openweathermap.org/data/2.5',

);