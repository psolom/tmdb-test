<?php

namespace TmApi;

/**
 * Class Client
 * @package TmApi
 */
class Client
{
    private $_apiKey;
    private $_httpClient;

    /**
     * Client constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
        $this->setHttpClient();
    }

    /**
     * Set API Key
     * @param string $apiKey
     */
    protected function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
    }

    /**
     * Get API Key
     */
    protected function getApiKey()
    {
        return $this->_apiKey;
    }

    /**
     * Http client setter
     */
    public function setHttpClient()
    {
        $this->_httpClient = new Http($this->getApiKey(), \TmApi\Api::BASE_URL);
    }

    /**
     * Http client getter
     * @return Http
     */
    public function getHttpClient()
    {
        return $this->_httpClient;
    }

    /**
     * @return Authenticate
     */
    public function getAuthenticate()
    {
        return new Authenticate($this);
    }
}