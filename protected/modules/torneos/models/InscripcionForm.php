<?php
/*
Formulario de registro de tipo de consola del jugador, y tambien para ingresar el pago de inscripcion.
*/
class InscripcionForm extends CFormModel
{
	public $path;
	public $console_id;

	public function rules()
	{
		return array(
			array('console_id,path', 'required'),
		);
	}
	
	/*
	 Lista general de consolas
	*/
	public function getTypeConsoleList()
	{
		$model=Consoles::model()->findAll('state = 1 and id!=3');
		return CHtml::listData($model,"id","name");	
	}
	
}
?>