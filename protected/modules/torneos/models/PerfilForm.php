<?php
/*
Formulario de registro de consola a un 
*/
class PerfilForm extends CFormModel
{
	public $path;

	public function rules()
	{
		return array(
			array('path', 'safe'),
		);
	}
	
}
?>