<?php

class TournamentGroupPositionSoccer extends CActiveRecord
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
		return 'tournament_group_position_soccer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("tournament_group_position_id,gf,gc,dg,pj,pg,pe,pp,state","required"),
			array('tournament_group_position_id,gf,gc,dg,pj,pg,pe,pp,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'tournamentPosition'=>array(self::BELONGS_TO,'TournamentGroupPosition','tournament_group_position_id'),
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

	public function decidePoint($score1,$score2)
	{
		if($score1>$score2)
			return array(3,0);
		else if($score2>$score1)
			return array(0,3);
		else if($score2==$score1)
			return array(1,1);
	}

}
