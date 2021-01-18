<?php

/**
 * SendForm class.
 * SendForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SendForm extends CFormModel
{
	public $email;
	public $subject="Envío de registros";
	public $body;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email, subject, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Correo destinatario',
			'subject'=>'Asunto',
			'body'=>'Mensaje adicional',
		);
	}
}