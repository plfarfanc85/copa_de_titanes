<?php

class TournamentGroup extends CActiveRecord
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
		return 'tournament_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("name,tournament_coordinator_id,state","required"),
			array('name,tconsole_id,state', 'safe', 'on'=>'search'),
			array('tournament_coordinator_id,tconsole_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tournamentDetail'=>array(self::HAS_MANY,'TournamentDetail','tournament_group_id'),
			'phase'=>array(self::BELONGS_TO,'TournamentPhase','tournament_phase_id'),
			'rrhh'=>array(self::BELONGS_TO,'UserRrhh','tournament_coordinator_id'),
			'tournamentConsole'=>array(self::BELONGS_TO,'TournamentConsole','tconsole_id'),
			'tournamentGroupPosition'=>array(self::HAS_MANY,'TournamentGroupPosition','tournament_group_id'),
			'tournamentMatchs'=>array(self::HAS_MANY,'TournamentMatch','tournament_group_id'),
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
		$criteria->compare('t.state',$this->state);
		
		#$criteria->addCondition('t.estado != 2');
		
		$criteria->order = "t.fecha DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getStateLabel()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'En Juego',
			3=>'Terminado',
			4=>'Cancelado'
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

		return $label;
	}

	/*
	Validar el cambio de estado del grupo, dependiendo de los partidos.
	*/
	public function changueStatus($match_state)
	{
		//Si el partido esta en curso y el grupo esta activo, cambia a estado en curso
		if($match_state == 2 or $match_state == 4)
		{
			if($this->state == 1)
				$this->state = 2;
		}	

		//Si el partido esta en Terminado y todos los partidos del grupo estan terminados, entonces el grupo cambia a estado terminado
		if($match_state == 3 or $match_state == 4)
		{
			$finished = 0;
			$matchs = TournamentMatch::model()->findAll('tournament_group_id = ?',array($this->id));
			foreach ($matchs as $key => $value) 
			{
				if($value->state == 3 or $value->state == 4)
					$finished += 1;
			}
			#echo count($matchs);die;
			//Si todos los partidos estan finalizados, se finaliza en grupo.
			if(count($matchs) == $finished)
				$this->state = 3;
		}	
			
	}

	public function getLabelName($id)
	{
		$list = array(
			1 => 'A',
			2 => 'B',
			3 => 'C',
			4 => 'D',
			5 => 'E',
			6 => 'F',
			7 => 'G',
			8 => 'H',
			9 => 'I',
			10 => 'J',
			11 => 'K',
			12 => 'L',
			13 => 'M',
			14 => 'N',
			15 => 'O',
			16 => 'P',
			17 => 'Q',
			18 => 'R',
			19 => 'S',
			20 => 'T',
			21 => 'U',
			22 => 'V',
			23 => 'W',
			24 => 'X',
			25 => 'Y',
			26 => 'Z',
			);

		return $list[$id];	
	}

	/*
	Devuelve el label de la consola asignada a cada grupo
	*/
	public function getConsoleNameLabel()
	{
		if($this->tournamentConsole)
			return '<span class="label label-default">'.$this->tournamentConsole->name.'</span>';
		else 
			return '<span class="label label-default">Sin Consola</span>';
	}

	/*
	Coordinador del grupo
	*/
	public function getCoordinator()
	{
		return '<span class="label label-default">'.$this->rrhh->name.' '.$this->rrhh->surname.'</span>';	
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
	Total de partido de los jugadores - Desempeño
	*/
	public $total;
	public function getTotalByPlayer($id)
	{
		$criteria = new CDbCriteria;
		
		if($id == 0)//todos los partidos jugados
		{
			$criteria->join = "
				INNER JOIN tournament_match tm ON tm.tournament_group_id = t.id
				INNER JOIN tournament_match_detail tmd ON tmd.tournament_match_id = tm.id
			";

			$criteria->select = "count(tm.id) total";

			$criteria->addCondition("tmd.player_id = ".Yii::app()->user->id." and tm.state = 3");
		}
		else if($id > 0)
		{
			$criteria->join = "
			INNER JOIN tournament_group_position tgp ON tgp.tournament_group_id = t.id
			INNER JOIN tournament_group_position_soccer tgps ON tgps.tournament_group_position_id = tgp.id
			";

			if($id == 1)
				$criteria->select = 'sum(tgps.pg) total';	
			else if($id == 2)
				$criteria->select = 'sum(tgps.pp) total';	
			else if($id == 3)
				$criteria->select = 'sum(tgps.pe) total';
			else if($id == 4)
				$criteria->select = 'sum(tgps.gf) total';
			else if($id == 5)
				$criteria->select = 'sum(tgps.gc) total';

			$criteria->addCondition("tgp.player_id = ".Yii::app()->user->id);		
		}	

		#echo '<pre>'.print_r($criteria->toArray(),true).'</pre>';die;

		$model = TournamentGroup::model()->findAll($criteria);
		if($model)
		{
			foreach ($model as $key => $value) {
				return ($value->total)?$value->total:0;
			}
		}	
		else 
			return 0;
	}
}
