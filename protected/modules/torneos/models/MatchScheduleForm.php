<?php
/*
Formulario de registro de tipo de consola del jugador, y tambien para ingresar el pago de inscripcion.
*/
class MatchScheduleForm extends CFormModel
{
	public $tournament_match_id;
	public $day_Schedule;
	public $hour_Schedule;

	public function rules()
	{
		return array(
			array('tournament_match_id,day_Schedule,hour_Schedule', 'required'),
		);
	}
	
	public function getScheduleListDay()
	{
		$match = TournamentMatch::model()->findByPk($this->tournament_match_id);
		$start = $match->tournamentGroup->phase->session->tournament->start_date;
		$end = $match->tournamentGroup->phase->session->tournament->end_date;

		$datetimeS = new DateTime($start);
		$datetimeE = new DateTime($end);
		$interval = $datetimeS->diff($datetimeE);
		$n = $interval->format('%a');

		$lista = array();

		for($i=1; $i<=$n+1; $i++) // bucle para los días
		{
			$lista[$i] = $datetimeS->format('Y-m-d');
			$datetimeS->add(new DateInterval('P1D'));
		}

		return $lista;
	}

	public function getScheduleListHour()
	{
		$fecha = date('Y-m-d');
		$datetimeS = new DateTime($fecha);
		$lista = array();

		for($i=1;$i<48;$i++)
		{
			$lista[$i] = $datetimeS->format('G:i');
			$datetimeS->add(new DateInterval('PT30M'));
		}

		return $lista;
	}
	
}
?>