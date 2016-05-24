<?php

namespace TmApi\Rest;

use TmApi\ApiAbstract;

/**
 * Class Discover
 * @package TmApi\Rest
 */
class Discover extends ApiAbstract
{
    /**
     * Returns movies list acording to criteria
     * @param array $params
     * @return array|object
     */
    public function movie($params = [])
    {
        return $this->getHttp()->get("discover/movie", $params)->parseJson();
    }
}