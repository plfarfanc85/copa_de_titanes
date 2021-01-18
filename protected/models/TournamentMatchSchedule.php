<?php

class TournamentMatchSchedule extends CActiveRecord
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
		return 'tournament_match_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("tournament_match_id,player_id,date_schedule,state","required"),
			array('tournament_match_id,player_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(self::BELONGS_TO,'Player','player_id'),
			'match'=>array(self::BELONGS_TO,'TournamentMatch','tournament_match_id'),
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

		$criteria->compare('t.tournament_match_id',$this->tournament_match_id);
		$criteria->compare('t.player_id',$this->player_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function actionGetStates()
	{
		$array = array(
  			0 => "Opcional",
			1 => "Confirmado",
			2 => "Cancelado",
		);
		return $array;
	}	

	public function getTestLabel()
	{
		$list =  array(
			0=>'<span class="label label-warning">Opcional</span>',
			1=>'<span class="label label-success">Confirmado</span>',
			2=>'<span class="label label-danger">Confirmado</span>',
			);

		return $list[$this->state];
	}
}
