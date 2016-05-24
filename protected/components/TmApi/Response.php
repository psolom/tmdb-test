<?php

namespace TmApi;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Response
 * @package TmApi
 */
class Response
{
    private $_response;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct($response)
    {
        $this->_response = $response;
    }

    /**
     * Parse response as JSON string
     * @return object|array
     */
    public function parseJson()
    {
        $result = $this->_response->getBody()->getContents();
        return json_decode($result);
    }
}