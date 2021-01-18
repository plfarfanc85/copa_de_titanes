<?php

class TournamentSession extends CActiveRecord
{
	public $group_id;

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
		return 'tournament_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("name,tournament_id,state","required"),
			array('name,state', 'safe', 'on'=>'search'),
			array('tournament_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tournament'=>array(self::BELONGS_TO,'Tournament','tournament_id'),
			'tournamentType'=>array(self::BELONGS_TO,'TournamentType','tournament_type_id'),
			'game'=>array(self::BELONGS_TO,'Game','game_id'),
			'phase' => array(self::HAS_MANY, 'TournamentPhase', 'tournament_session_id'),
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
		$criteria->compare('t.tournament_id',$this->tournament_id);
		
		#$criteria->addCondition('t.estado != 2');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getListState()
	{
		$list =  array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'Finalizado'
			);

		return $list;
	}

	public function getState()
	{
		$list = $this->getListState();

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

}
