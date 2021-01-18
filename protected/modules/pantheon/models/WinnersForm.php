<?php
/*
Formulario de registro de ganadores del torneo. No registra los ganadores, solo registra la cantidad de ganadores. 
*/
class WinnersForm extends CFormModel
{
	public $percent;
	public $position;

	public function rules()
	{
		return array(
			array('percent,position', 'required'),
		);
	}
	
}
?>