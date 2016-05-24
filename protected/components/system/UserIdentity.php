<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $sessionId;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$client = new \TmApi\Client($this->username);

		try {
			$session = $client->getAuthenticate()->getGuestSession();

			if($session->success === true) {
				$cookie = new GuestSessionCookie();
				$cookie->set($session->guest_session_id, strtotime($session->expires_at));

				$this->errorCode = self::ERROR_NONE;
			} else {
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			}
		} catch (Exception $e) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}

		return !$this->errorCode;
	}
}