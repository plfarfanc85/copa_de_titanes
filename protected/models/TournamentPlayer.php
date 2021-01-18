<?php

class TournamentPlayer extends CActiveRecord
{
	public $names;
	public $username;

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
		return 'tournament_player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("tournament_id,player_id,state","required"),
			array("console_id,path","safe"),
			array('tournament_id,player_id,console_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(self::BELONGS_TO,'Player','player_id'),
			'tournament'=>array(self::BELONGS_TO,'Tournament','tournament_id'),
			'console'=>array(self::BELONGS_TO,'Console','console_id'),
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

	public function search($pages = 50)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		// to search date ranges.
		$criteria=new GDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.tournament_id',$this->tournament_id,true);
		$criteria->compare('t.player_id',$this->player_id);
		$criteria->compare('t.console_id',$this->console_id);
		$criteria->compare('t.state',$this->state);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getState()
	{
		$list = array(
			0=>'Preinscrito',
			1=>'Pendiente Validación', //Validando pago
			2=>'Inscrito',
			3=>'CheckIn',
			);

		return $list[$this->state];
	}

	public function getStateLabel()
	{
		$list =  array(
			0=>'<span class="label label-info">Preinscrito</span>',//No garantiza la participacion en el torneo, hasta que no reliace el pago no queda inscrito en el torneo
			1=>'<span class="label label-warning">Pendiente Validación</span>',
			2=>'<span class="label label-info">Inscrito</span>', //Pago realizado
			3=>'<span class="label label-inverse">CheckIn</span>', //Hizo checkin en el torneo
			4=>'<span class="label label-danger">Pago Denegado</span>',
			5=>'<span class="label label-success">Dentro del Torneo</span>', //Seleccionó consola
			);

		return $list[$this->state];
	}

	/*
	Realizar el sorteo de los jugadores del torneo - sorte de posición
	*/
	public function getDrawTournament($tournament)
	{
		$playersTotal = $tournament->tournamentDetail->amount*$tournament->tournamentDetail->players;//Cantidad de grupos del torneo x Cantida de jugadores de un grupo
		$consols = explode(',', $tournament->consoles);
		$players = array();
		$playerList = array();
		$playerCount = 0;

		foreach ($consols as $value) 
		{
			$playerConsole = TournamentPlayer::model()->findAll('tournament_id = ? and state = 5 and console_id = ?',array($tournament->id,$value));
			$playerCount += count($playerConsole);
			$players[] = $playerConsole;
		}
		#echo '<pre>'.print_r($playerCount,true).'</pre>';die;
		#$playerConsole2 = TournamentPlayer::model()->findAll('tournament_id = ? and state = 5 and console_id = 2',array($tournament->id));
		#$playerList2 = array();
		#echo $playerCount;die;
		#echo count($playerConsole2);die;
		#echo count($playerConsole1)+count($playerConsole2);die;
		if($playersTotal == $playerCount)//Validar que los jugadores totales configurados sea igual a los totales inscritos
		{
			//Colocamos los jugadores inscritos al torneo en un array antes de realizar el sorteo
			foreach ($players as $key => $value) 
			{
				#echo '<pre>'.print_r($value,true).'</pre>';die;
				foreach ($value as $key2 => $value2) 
				{
					#echo $value2->player_id;die;
					$playerList[$key][$key2] = $value2->player_id;	
				}

				//sorteo random
				#echo '<pre>'.print_r($playerList[$key],true).'</pre>';die;
				shuffle($playerList[$key]); 
				#echo '<pre>'.print_r($playerList[$key],true).'</pre>';die;
			}
			/*
			foreach ($playerConsole2 as $key => $value) {
				$playerList2[] = $value->player_id;
			}
			*/
			#echo '<pre>'.print_r($playerList,true).'</pre>';
            #echo '<pre>'.print_r($playerList2,true).'</pre>';die;   
			//sorteo aleatorio de jugadores
			#shuffle($playerList1); 
			#shuffle($playerList2); 

			return $playerList;
		}	
		
		return null;
	}

	public function validateRegister($player_id)
	{
		$model = TournamentPlayer::model()->find('player_id = ?',array($player_id));

		if($model->state == 3)
			return 1;
		else
			return 0;
	}

	/*
	Validar si un jugador esta inscrito al un torneo
	*/
	public function validatePlayer($id)
	{
		//validar si el usuario ya tienen un proceso de inscripcion
		$model = TournamentPlayer::model()->find('tournament_id = :id and player_id = :player',array(':id'=>$id,':player'=>Yii::app()->user->id));
		$modelAll = TournamentPlayer::model()->findAll('tournament_id = :id and state != 4',array(':id'=>$id)); // Si el pago fue denegado

		//validar si todavia hay cupo
		$tournament = Tournament::model()->findByPk($id);
        $inscritos = count($modelAll);
        $totalConfigurado = $tournament->tournamentDetail->amount*$tournament->tournamentDetail->players;
        
		if($model or ($inscritos==$totalConfigurado))
			return false;
		else
			return true;
	}

	/*
	Obetener opcioens de mi lista de inscripciones
	*/
	public function getOpciones($tournament_id)
	{
		#$tournament = Tournament::model()->findByPk($this->tournament_id);
		$tournamentPlayer = TournamentPlayer::model()->find('tournament_id = ? and player_id = ?',array($tournament_id,Yii::app()->user->id));
		#$inscritos = count($tournamentPlayer);
        #$totalConfigurado = $tournament->tournamentDetail->amount*$tournament->tournamentDetail->players;
        #echo $inscritos.' hola';die;
		#if($inscritos == $totalConfigurado)
		#{
		if($tournamentPlayer){
			if($tournamentPlayer->state == 0 or $tournamentPlayer->state == 4)// estado general para presencial y online
				return '<a href="#modal-dialog-1" facid="'.$tournamentPlayer->id.'" class="btn btn-warning lla" data-toggle="modal">Registrar Comprobante Pago</a> - '.
						CHtml::link("Registrarme con mis creditos",Yii::app()->createUrl("torneos/gestion/pagoconCreditos",array("tournament_id"=>$tournamentPlayer->tournament->id)), array('class'=>'btn btn-info','confirm' => 'Seguro que desea registrarse con tus creditos?'));	
			else if($tournamentPlayer->tournament->tournament_class_id == 1) // Si es presencial
			{
				if($tournamentPlayer->state == 2) //Si el estado es Inscrito y es un torneo presencial
					return '<a href="#modal-dialog-2" facid="'.$tournamentPlayer->id.'" class="btn btn-warning lla2" data-toggle="modal">Registrar Consola</a>';		
			}
			
		}
		else{
			return CHtml::link("Pre-registro",Yii::app()->createUrl("torneos/gestion/inscripcion",array("id"=>$tournament_id)), array('class'=>'btn btn-info','confirm' => 'Seguro que desea registrarse al torneo. Hasta que no realice el pago, no quedará registrado en el torneo .'));	
		}
		#}	
		
		return '';
	}

	public function getPlayerByConsole($id_tournament,$id_console)
	{
		$tournamentPlayer = TournamentPlayer::model()->findAll('tournament_id = ? and console_id = ?',array($id_tournament,$id_console));
		return count($tournamentPlayer);
	}

	/*
	Obtener los jugadores registrados - dashboard torneo
	Registered-> state = 2
	*/
	public function getPlayerRegistered($tournament_id)
	{
		$criteria = new GDbCriteria;
		$criteria->condition = "state NOT IN (0,1,4) and tournament_id = ".$tournament_id;

		return TournamentPlayer::model()->findAll($criteria);
	}

}
