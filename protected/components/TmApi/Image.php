<?php

namespace TmApi;

/**
 * Class Image
 * @package TmApi
 */
class Image extends ApiAbstract
{
    const IMAGE_BASE_URL = 'http://image.tmdb.org/t/p/';

    /**
     * @var string
     */
    private $_path;
    /**
     * @var string
     */
    private $_size;

    /**
     * Image constructor.
     * @param Client $client
     * @param string $path
     * @param string $size
     */
    public function __construct(Client $client, $path, $size = 'original')
    {
        parent::__construct($client);
        $this->_path = ltrim($path, '/');
        $this->_size = $size;
    }

    /**
     * Build full image URL
     * @return string
     */
    public function getUrl()
    {
        return self::IMAGE_BASE_URL . $this->_size . '/' . $this->_path;
    }

    /**
     * Save requested image to specified path
     * @param $destinationPath
     */
    public function save($destinationPath)
    {
        $this->getHttp()->getHttpClient()->request('GET', $this->getUrl(), [
            'sink' => $destinationPath,
        ]);
    }
}