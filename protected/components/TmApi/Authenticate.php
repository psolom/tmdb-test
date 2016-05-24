<?php

namespace TmApi;

/**
 * Class Authenticate
 * @package TmApi
 */
class Authenticate extends Api
{
    const AUTH_URL = 'https://www.themoviedb.org/authenticate';

    /**
     * Get new token
     */
    public function getToken()
    {
        $obj = $this->getHttp()->get('authentication/token/new')->parseJson();
        return $obj->request_token;
    }

    /**
     * Authenticate application in user's account
     * @param $token
     */
    public function authenticateAccount($token)
    {
        $authUrl = self::AUTH_URL;
        header("Location: {$authUrl}/{$token}");
    }

    /**
     * Get new guest session token
     * @return mixed
     * @throws \Exception
     */
    public function getGuestSession()
    {
        try {
            return $this->getHttp()->get('authentication/guest_session/new')->parseJson();
        } catch (\Exception $e) {
            if ($e->getCode() === 401) {
                throw new \Exception("Invalid API key");
            }
        }
    }
}