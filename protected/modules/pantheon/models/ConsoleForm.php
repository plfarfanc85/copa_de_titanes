<?php
/*
Formulario de registro de consola a un 
*/
class ConsoleForm extends CFormModel
{
	public $name;
	public $console_id;

	public function rules()
	{
		return array(
			array('name,console_id', 'required'),
		);
	}
	
	public function getTypeConsoleList()
	{
		$model=Consoles::model()->findAll('state = 1');
		return CHtml::listData($model,"id","name");	
	}
}
?>