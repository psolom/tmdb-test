<?php

namespace TmApi;

/**
 * Class ApiAbstract
 * @package TmApi
 */
abstract class ApiAbstract
{
    private $_client;

    /**
     * ApiAbstract constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Api client setter
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * Api client getter
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Returns Http client
     * @return Http
     */
    public function getHttp()
    {
        return $this->getClient()->getHttpClient();
    }

}