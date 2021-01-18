<?php

class TournamentPhase extends CActiveRecord
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
		return 'tournament_phase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("tournament_session_id,console_id,name,number,state","required"),
			array('name,state', 'safe', 'on'=>'search'),
			array('tournament_session_id,console_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'console'=>array(self::BELONGS_TO,'ConsoleGame','console_id'),
			'session'=>array(self::BELONGS_TO,'TournamentSession','tournament_session_id'),
			'tournamentGroup'=>array(self::HAS_MANY,'TournamentGroup','tournament_phase_id'),
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
		$criteria->compare('t.tournament_session_id',$this->tournament_session_id);
		
		#$criteria->addCondition('t.estado != 2');
		
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

	public function getPlayOffList()
	{
		$list = array(
			2 => "Final",
			4 => "Semi final",
			8 => "Cuartos de final",
			16 => "Octavos de final",
			32 => "Dieciseisavo de final",
			);

		return $list;
	}

	public function getPlayOffById($id)
	{
		$list = $this->getPlayOffList();
		return $list[$id];
	}

}
