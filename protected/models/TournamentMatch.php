<?php

class TournamentMatch extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tournament_match';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("name,tournament_group_id,state","required"),
			array("tconsole_id,date","safe"),
			array('tournament_group_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tournamentMatchDetail'=>array(self::HAS_MANY,'TournamentMatchDetail','tournament_match_id'),
			'tournamentConsole'=>array(self::BELONGS_TO,'TournamentConsole','tconsole_id'),
			'tournamentGroup'=>array(self::BELONGS_TO,'TournamentGroup','tournament_group_id'),
			'tournamentMatchSchedule'=>array(self::HAS_MANY,'TournamentMatchSchedule','tournament_match_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=&gt;label)
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

	public function getStateLabel()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'En Juego',
			3=>'Terminado',
			4=>'Cancelado',
			5=>'En edición'
			);

		if($this->state==0)
			$label = '<span class="label label-danger">Inactivo</span>';
		else if($this->state==1)
			$label = '<span class="label label-success">Activo</span>';
		else if($this->state==2)
			$label = '<span class="label label-info">En Juego</span>';
		else if($this->state==3)
			$label = '<span class="label label-inverse">Terminado</span>';
		else if($this->state==4)
			$label = '<span class="label label-warning">Cancelado</span>';
		else if($this->state==5)
			$label = '<span class="label label-warning">En Edición</span>';

		return $label;
	}

	public function getDateLabel()
	{
		if(!is_null($this->date))
			return '<span class="label label-success">'.date('d-m h:i',strtotime($this->date)).'</span>';
		else 
			return '<span class="label label-warning">Fecha por definir</span>';;
	}

	public function getActions()
	{
		$html = "";
		
		if($this->state == 0) 
			$html = '<li><a href="#">Activar</a></li>';
		else if($this->state == 1)
		{
			#$html = '<li><a href="#">Jugar</a></li>
            $html = '<li>'.CHtml::link("Jugar",Yii::app()->createUrl("pantheon/tournament/matchStatus",array("id_match"=>$this->id,"state"=>2))).'</li>';         
            #$html .= '<li><a href="#">Cancelar</a></li>';
		}	
        else if($this->state == 2) //Terminar - cuando ninguno de los 2 jugadores viene, el partido se ternima y no otorga puntos a nadie. Cancelar - cuando alguno de los jugadores no viene, se selecciona el jugador al que se le otorgaran los puntos. 
			$html = '<li><a href="#">Terminar</a></li>
                     <li><a href="#">Cancelar</a></li>
                     <li><a href="#">Inactivar</a></li>';
        else if($this->state == 3 and Yii::app()->user->getState("perfil") == 'super') 
        {
        	$html = '<li>'.CHtml::link("Deshacer",array("/pantheon/tournament/undoScore","id"=>$this->id),array('confirm'=>'Seguro que desea hacer reversión de marcador ?')).'</li>';                 
        } 
        else if($this->state == 4) 
			$html = '<li><a href="#">Activar</a></li>';                             

		return $html;
	}

	/*
	Desasignar la consola del grupo - fase 1
	*/
	public function unassignConsole()
	{
		if($this->state == 3 and $this->tournamentConsole->state == 2)
		{
			$tConsole = TournamentConsole::model()->findByPk($this->tournamentConsole->id);
			$tConsole->state = 1;

			if($tConsole->save())
				return true;
			else 
				return false;
		}

		return true;
	}

	/*
	Devuelve el label de la consola asignada al partido - Fase 2,3,4
	*/
	public function getConsoleNameLabel()
	{
		if($this->tournamentConsole)
			return '- <span class="label label-default">'.$this->tournamentConsole->name.'</span>';
		else 
			return '- <span class="label label-default">Sin Consola</span>';
	}

	/*
	Total de partido de los jugadores - Desempeño
	*/
	public function getTotalByPlayer($id)
	{
		$criteria = new CDbCriteria;
		$criteria->join = "
			INNER JOIN tournament_group_position tgp ON tgp.tournament_group_id = t.id
			INNER JOIN tournament_group_position_soccer tgps ON tgps.tournament_group_position_id = tgp.id
		";
		$model = EmailsCampaing::model()->findAll("game_id = ? and state = 1",array($id));
		if($model)
			return count($model);
		else 
			return 0;
	}

	/*
	Consultar totoles de preinscritos a cada torneo
	*/
	public function getTotal($id)
	{
		$model = EmailsCampaing::model()->findAll("game_id = ? and state = 1",array($id));
		if($model)
			return count($model);
		else 
			return 0;
	}

	/*
	Algoritmo de asingacion de fecha a los partidos fase de Grupos - aplica para torneos presenciales
	*/
	public function calculateDate($countGroup,$inicio)
	{
		//Se debe calcular dependiendo de la cantida de consolas
		$consoles = TournamentConsole::model()->findAll('state = 1');
		$minutes = 15; //minutos por partido, por ahora configurado por codigo;
		$matchs = 6;//partidos por consola

		// 1 Consola x grupo, y cada consola se demora 1 hora y media en terminar el grupo
		$time = $matchs*$minutes;

		if((($countGroup-1) % (count($consoles)/2) == 0) and $countGroup > (count($consoles)/2)) //A partir de la septima consola se suma el tiempo
		{
			$dateMatch = new DateTime($inicio);
			$date = $dateMatch->add(new DateInterval('PT'.$time.'M'));
			return $date->format('Y-m-d H:i:s');
		}	
		else 
			return $inicio;
	}

	/*
	Algoritmo de asingacion de fecha a los partidos fase de Playoff
	*/
	public function calculateDatePLayOff($countGroup,$inicio)
	{
		//Se debe calcular dependiendo de la cantida de consolas
		$consoles = TournamentConsole::model()->findAll('state = 1');
		#echo count($consoles);die;
		$minutes = 15; //minutos por partido, por ahora configurado por codigo;
		$matchs = 1;//partidos por consola

		// 1 Consola x grupo, y cada consola se demora 1 hora y media en terminar el grupo
		$time = $matchs*$minutes;
		#echo ($countGroup-1) % (count($consoles)/2);die;

		if((($countGroup-1) % (count($consoles)/2) == 0) and $countGroup > (count($consoles)/2)) //A partir de la septima consola se suma el tiempo
		{
			$dateMatch = new DateTime($inicio);
			$date = $dateMatch->add(new DateInterval('PT'.$time.'M'));
			return $date->format('Y-m-d H:i:s');
		}	
		else 
			return $inicio;
	}

	/*
	Obtener lista de opciones para los partidos de partidos online
	*/
	public function getSchudelOptions()
	{
		if($this->state==1)
		{
			if($this->tournamentGroup->phase->session->tournament->tournament_class_id == 2 && is_null($this->date)) // solo si es online
			{
				$players = array();

				foreach ($this->tournamentMatchDetail as $value) {
					$players[] = $value->player_id;
				}
				
				if(in_array(Yii::app()->user->id,$players))# && count($this->tournamentMatchSchedule)<=10
				{
					return CHtml::link("Agendar",Yii::app()->createUrl("torneos/gestion/agendarPartido",array("id"=>$this->id)), array('class'=>'btn btn-primary btn-xs m-r-5'));	
				}	
			}	
		}

		return;	
	}

	/*
	Boton de CheckIn para el partido
	*/
	public function getCheckInOption()
	{
		$matchDetail = TournamentMatchDetail::model()->find('tournament_match_id = ? and player_id = ?',array($this->id, Yii::app()->user->id));

		if(!is_null($this->date) and $matchDetail)
		{
			if($matchDetail->state == 1)
				return CHtml::link("Check-In",Yii::app()->createUrl("torneos/gestion/realizarCheckin",array("id"=>$this->id)), array('class'=>'btn btn-primary btn-xs m-r-5'));	
		}

		return null;
	}

	/*
	Opcion de registrar el marcador del partido - aplica para torneos online
	*/
	public function getScoreOption()
	{
		if($this->state==2)
		{
			if($this->tournamentGroup->phase->session->tournament->tournament_class_id == 2) // solo si es online
			{
				$players = array();

				foreach ($this->tournamentMatchDetail as $value) {
					$players[] = $value->player_id;
				}
				
				if(in_array(Yii::app()->user->id,$players))# && count($this->tournamentMatchSchedule)<=10
				{
					return CHtml::link("Marcador",Yii::app()->createUrl("torneos/gestion/regitrarMarcador",array("id"=>$this->id)), array('class'=>'btn btn-primary btn-xs m-r-5'));	
				}
			}
		}	
	}
}
