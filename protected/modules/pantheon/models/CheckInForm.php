<?php
/*
Formulario de registro de marcadores 
*/
class CheckInForm extends CFormModel
{
	public $player_id;

	public function rules()
	{
		return array(
			array('player_id', 'required'),
		);
	}
	
	public function getList($id)
	{
		$criteria = new CDbCriteria;
		$criteria->order = "name ASC";
		$criteria->select = "p.id,concat(p.name,p.surname,' - ',p.dni) names";
		$criteria->condition = "t.state = 5 and tournament_id = ".$id;
		$criteria->join = "
				INNER JOIN player p ON p.id = t.player_id
		";
		$model=TournamentPlayer::model()->findAll($criteria);
		return CHtml::listData($model,"id","names");
	}
}
?>