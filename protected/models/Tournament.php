<?php

class Tournament extends CActiveRecord
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
		return 'tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name,game_id,tournament_type_id,tournament_class_id,start_date,end_date,consoles,description,city_id,profit,test,state', 'safe', 'on'=>'search'),
			array("name,game_id,tournament_type_id,tournament_class_id,consoles,start_date,end_date,inscription,description,city_id,test,state","required"),
			array("winner_id,profit","safe"),
			array('game_id,tournament_type_id,tournament_class_id,inscription,profit,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tournamentType'=>array(self::BELONGS_TO,'TournamentType','tournament_type_id'),
			'game'=>array(self::BELONGS_TO,'Game','game_id'),
			'tournamentDetail'=>array(self::BELONGS_TO,'TournamentDetail','tournament_detail_id'),
			'tournamentStructure'=>array(self::BELONGS_TO,'TournamentStructure','structure_id'),
			'city'=>array(self::BELONGS_TO,'City','city_id'),
			'session' => array(self::HAS_MANY, 'TournamentSession', 'tournament_id'),
			'tournamentPlayers' => array(self::HAS_MANY, 'TournamentPlayer', 'tournament_id'),
			'tournamentWinners' => array(self::HAS_MANY, 'TournamentWinners', 'tournament_id'),
			'tournamentPlayersNotPayCanceled' => array(self::HAS_MANY, 'TournamentPlayer', 'tournament_id','condition'=>'tournamentPlayersNotPayCanceled.state != 4'),
			'tournamentPlayersSignedUp' => array(self::HAS_MANY, 'TournamentPlayer', 'tournament_id','condition'=>'tournamentPlayersSignedUp.state = 5'),
			'tournamentSessions' => array(self::HAS_MANY, 'TournamentSession', 'tournament_id'),
			'tournamentClass'=>array(self::BELONGS_TO,'TournamentClass','tournament_class_id'),
			'winner'=>array(self::BELONGS_TO,'Player','winner_id'),
			'type'=>array(self::BELONGS_TO,'TournamentType','tournament_type_id'),
			#'session' => array(self::HAS_MANY, 'TournamentSession', 'tournament_id', 'condition'=>'session.state = 3'),
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
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.game_id',$this->game_id);
		$criteria->compare('t.tournament_type_id',$this->tournament_type_id);
		$criteria->compare('t.start_date',$this->start_date,true);
		$criteria->compare('t.state',$this->state);
		$criteria->compare('t.test',$this->test);
		
		#$criteria->addCondition('t.estado != 2');
		
		$criteria->order = "t.start_date DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getState()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'Finalizado'
			);

		return $list[$this->state];
	}

	public function getStateLabel()
	{
		$list =  array(
			0=>'<span class="label label-danger">Inactivo</span>',
			1=>'<span class="label label-success">Activo</span>',
			2=>'<span class="label label-inverse">Finalizado</span>'
			);

		return $list[$this->state];
	}

	public function getTestLabel()
	{
		$list =  array(
			1=>'<span class="label label-danger">Si</span>',
			0=>'<span class="label label-success">No</span>',
			);

		return $list[$this->test];
	}

	/*
	Dahsboard - torneos realizados
	*/
	public function getTotal()
	{
		$model = Tournament::model()->findAll('test = 0');

		return count($model);
	}

	/*
	Formato a la fecha de inicio del torneo para el dashboard del torneo
	*/
	public function getDateFormated()
	{
		$mesArray = array('01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic');
		$fecha = date_create($this->start_date);
		return $fecha->format('d').' de '.$mesArray[$fecha->format('m')];

	}


}
