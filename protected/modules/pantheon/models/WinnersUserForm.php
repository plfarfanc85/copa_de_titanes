<?php
/*
Formulario de registro de ganadores del torneo. No registra los ganadores, solo registra la cantidad de ganadores. 
*/
class WinnersUserForm extends CFormModel
{
	public $player_id;
	public $position;
	public $tournament_id;

	public function rules()
	{
		return array(
			array('player_id,position,tournament_id', 'required'),
		);
	}

	/*
	Obtiene la lista de jugadores del torneo para poder elegir el ganador
	*/
	public function getList()
	{
		$tournamentPlayer = TournamentPlayer::model()->findAll('tournament_id = ?',array($this->tournament_id));
		$players = array();

		foreach ($tournamentPlayer as $key => $value) {
			$players[$value->player_id] = $value->player->name.' '.$value->player->surname.' '.$value->player->dni;
		}

		return $players;	
	}
	
}
?>