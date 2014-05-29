<?php namespace JCrowe\OpenWeather;

class OpenWeatherResponse {
    private $_response = null;
    private $_code = null;
    private $_info = null;
    private $_error = null;

    public function __construct($response, $code, $info = null, $error = null) {
        try {
            $this->_response = (json_decode($response, true))?:$response;
        } catch (Exception $e) {
            $this->_response = $response;
        }
        $this->_code = $code;
        $this->_info = $info;
        $this->_error = $error;
    }

    public function getResponse() {
        return !empty($this->_response) ? $this->_response : null;
    }

    public function isValid() {
        return $this->_code == 200;
    }

    public function getInfo() {
        return $this->_info;
    }

    public function errors() {
        return $this->hasErrors() ? array($this->_error) : array();
    }

    public function data() {
        return $this->getResponse();
    }

    public function hasErrors() {
        return ($this->isValid() || !empty($this->_error));
    }

}