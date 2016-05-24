<?php

/**
 * LoginForm class.
 */
class LoginForm extends CFormModel
{
	public $api_key;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('api_key', 'required'),
			array('rememberMe', 'boolean'),
			array('api_key', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'api_key' => Yii::t('app', 'API key'),
			'rememberMe' => Yii::t('app', 'Remember me next time'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->api_key, $this->api_key);
			if(!$this->_identity->authenticate()) {
				$this->addError('api_key', 'Incorrect API key.');
			}
		}
	}

	/**
	 * Logs in the user using the given form data.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->api_key, $this->api_key);
			$this->_identity->authenticate();
		}

		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = $this->rememberMe ? 3600 * 24 * 1 : 0; // 1 day
			if(Yii::app()->user->login($this->_identity, $duration)) {
				return true;
			}
		}

		return false;
	}
}
