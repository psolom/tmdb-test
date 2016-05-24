<?php
/**
 * Class WebUser
 *
 * @property IdentityModel $identity
 */
class WebUser extends CWebUser
{
    /**
     * @var null|array User identity
     */
    private $_identity;

    /**
     * Returns identity
     * @return IdentityModel
     */
    function getIdentity()
    {
        if (!$this->isGuest && $this->_identity === null) {
            $this->setIdentity($this->id);
        }
        return $this->_identity;
    }

    /**
     * Returns identity
     * @param $apiKey
     */
    function setIdentity($apiKey)
    {
        $model = new IdentityModel();
        $model->apiKey = $apiKey;
        $model->guestSessionId = $this->getGuestSessionId();
        $this->_identity = $model;
    }

    /**
     * Returns guest_session_id stored while authentication
     * @return array|string
     * @throws CHttpException
     */
    private function getGuestSessionId()
    {
        $cookie = new GuestSessionCookie();
        $sessionId = $cookie->get();

        if($sessionId === null) {
            $this->loginRequired();
        }

        return $sessionId;
    }

//    /**
//     * Return guest_session_id stored while authentication
//     * @return array|string
//     * @throws CHttpException
//     */
//    public function login($identity, $duration=0)
//    {
//        if(parent::login($identity, $duration)) {
//            setIdentity
//        }
//    }
}