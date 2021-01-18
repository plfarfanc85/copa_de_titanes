<?php
/*
Formulario de registro de marcadores 
*/
class ScoreForm extends CFormModel
{
	public $player_id_1;
	public $score1;
	public $player_id_2;
	public $score2;
	public $match_id;
	public $type;

	public function rules()
	{
		return array(
			array('player_id_1, score1, player_id_2, score2, match_id, type', 'required'),
		);
	}

	public function registerAttributes($form_arr,$match_id,$type)
	{
		$this->player_id_1 = $form_arr[0]['player_id'];
		$this->player_id_2 = $form_arr[1]['player_id'];
		$this->match_id = $match_id;
		$this->type = $type;
	}

	
}
?>