<?php
/*
Formulario de registro de consola a un 
*/
class TournametConsoleForm extends CFormModel
{
	public $group_id;
	public $console_id;
	public $match_id;

	public function rules()
	{
		return array(
			array('group_id,console_id,match_id', 'required'),
		);
	}
	
	/*
	Devuelve el nombre de la consola en el modal de asignar consola al grupo
	*/
	public function getList()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "names ASC";
		$criteria->select = "t.id,concat(t.name,c.name) names";
		$criteria->condition = "t.state = 1";
		$criteria->join = "
				INNER JOIN console c ON c.id = t.console_id
		";
		$model=TournamentConsole::model()->findAll($criteria);
		return CHtml::listData($model,"id","names");
	}

}
?>