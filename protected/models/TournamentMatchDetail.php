<?php

class TournamentMatchDetail extends CActiveRecord
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
		return 'tournament_match_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("tournament_match_id,player_id,point,tournament_match_type_id,state","required"),
			array("path","safe"),
			array('tournament_match_id,player_id,point,tournament_match_type_id,state', 'numerical', 'integerOnly'=>true),
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

	//Obtener estados
	public function getStateList()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'Terminado'
			#3=>'CheckIn'
			);

		return $list;
	}



}
