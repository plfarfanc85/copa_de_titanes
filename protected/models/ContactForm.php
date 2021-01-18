<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	private $secret_local = '';
	private $secret_prod = '';

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			#array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			#array('verifyCode','validateCaptcha')
		);
	}

	public function validateCaptcha($attribute,$params)
	{
		#echo $this->$attribute;die;
		$secret = (YII_DEBUG)?$this->secret_local:$secret_prod;
		#echo $secret;die;
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $this->$attribute;
		$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		#var_dump($rsp);die;
		$arr = json_decode($rsp,TRUE);
		#echo '<pre>'.print_r($arr,true).'</pre>';die;
		var_dump($arr);die;

		if(!$arr['success'])
		$this->addError($attribute, 'Error de validación del Captcha');
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}