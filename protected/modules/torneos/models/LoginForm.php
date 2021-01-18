<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $olimpico = 0; // Identifica si el usuario conectado pertenece a un Admin de Portal
	public $username;
	public $password;
	public $rememberMe;
	public $sha1 = false;
	public $tipo = 'players';

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'Usuario',
			'password'=>'Contraseña',
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->olimpico = 1;
			$this->_identity->sha1 = $this->sha1;
			$this->_identity->tipo = $this->tipo;
			$this->_identity->olimpico = $this->olimpico;
			if(!$this->_identity->authenticate())
				$this->addError('password','Usuario o Contraseña incorrectos.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 * $sha1 identifica si los datos vienen codificados con sha1, opción para autenticar desde el Back
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity = new UserIdentity($this->username,$this->password);
			$this->_identity->conexion = 0;
			$this->_identity->sha1 = $this->sha1;
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*5 : 0; // 5 days
			Yii::app()->user->login($this->_identity,$duration);
			#yii::app()->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']); 
			return true;
		}
		else
			return false;
	}
}
