<?php

namespace TmApi;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Http
 * @package TmApi
 */
class Http
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $_client;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Http constructor.
     * @param string $apiKey
     * @param string $baseUri
     */
    public function __construct($apiKey, $baseUri = null)
    {
        $this->setHttpClient($apiKey, $baseUri);
    }

    /**
     * Initialize HTTP client
     * @param $apiKey
     * @param $baseUri
     */
    public function setHttpClient($apiKey, $baseUri)
    {
        $this->params['api_key'] = $apiKey;

        $this->_client = new HttpClient([
            'base_uri' => $baseUri,
        ]);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->_client;
    }

    /**
     * Performs GET request
     * @param string $uri
     * @param array $params
     * @return Response
     */
    public function get($uri, $params = [])
    {
        $params['api_key'] = $this->params['api_key'];

        $response = $this->_client->request('GET', $uri, [
            'query' => $params,
        ]);

        return new Response($response);
    }

    /**
     * Performs POST request
     * @param string $uri
     * @param string $body
     * @param array $params
     * @param array $headers
     * @return Response
     */
    public function post($uri, $body, $params = [], $headers = [])
    {
        $params['api_key'] = $this->params['api_key'];

        $response = $this->_client->request('POST', $uri, [
            'body' => $body,
            'query' => $params,
            'headers' => $headers,
        ]);

        return new Response($response);
    }

    /**
     * Performs POST request sending JSON encoded string
     * @param string $uri
     * @param array $body
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function postJson($uri, $body, $params = [])
    {
        if(!is_array($body)) {
            throw new \Exception(__METHOD__ . " expects parameter \"body\" to be array.");
        }

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        return $this->post($uri, json_encode($body), $params, $headers);
    }

    /**
     * Performs DELETE request
     * @param string $uri
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function delete($uri, $params = [])
    {
        $params['api_key'] = $this->params['api_key'];

        $response = $this->_client->request('DELETE', $uri, [
            'query' => $params,
        ]);

        return new Response($response);
    }
}