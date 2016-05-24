<?php

namespace TmApi\Rest;

use TmApi\ApiAbstract;

/**
 * Class GuestAccount
 * @package TmApi\Rest
 */
class GuestAccount extends ApiAbstract
{
    /**
     * Retrieve list of movies voted by the guest account
     * @param string $guest_session_id
     * @param array $params
     * @return array|object
     */
    public function getRatedMovies($guest_session_id, $params = [])
    {
        return $this->getHttp()->get("guest_session/{$guest_session_id}/rated/movies", $params)->parseJson();
    }
}