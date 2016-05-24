<?php

namespace TmApi\Rest;

use TmApi\ApiAbstract;

/**
 * Class Movies
 * @package TmApi\Rest
 */
class Movies extends ApiAbstract
{
    /**
     * Returns specified movie details
     * @param $id
     * @param array $params
     * @return array|object
     */
    public function info($id, $params = [])
    {
        return $this->getHttp()->get("movie/{$id}", $params)->parseJson();
    }

    /**
     * Returns top rated movie list
     * @param array $params
     * @return array|object
     */
    public function topRated($params = [])
    {
        return $this->getHttp()->get("movie/top_rated", $params)->parseJson();
    }

    /**
     * Rates movie (set vote)
     * @param $id
     * @param float $rating
     * @param array $params
     * @return array|object
     * @throws \Exception
     */
    public function rate($id, $rating, $params = [])
    {
        $body = ['value' => (float)$rating];
        return $this->getHttp()->postJson("movie/{$id}/rating", $body, $params)->parseJson();
    }

    /**
     * Unrate movie (remove vote)
     * @param $id
     * @param array $params
     * @return array|object
     * @throws \Exception
     */
    public function unrate($id, $params = [])
    {
        return $this->getHttp()->delete("movie/{$id}/rating", $params)->parseJson();
    }
}