<?php

class SocialNetwork extends CActiveRecord
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
		return 'social_network';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("entity,entity_id,comments,published,player_id,father","required"),
			array('entity_id,player_id,father', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(self::BELONGS_TO,'Player','player_id'),
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
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	/*
	Obtiene las publicaciones de un torneo o partido.
	*/
	public function getPublicaciones($entidad,$entidad_id)
	{
		$criteria = new GDbCriteria;
		$criteria->condition = 'entity = "'.$entidad.'" and  entity_id = '.$entidad_id;
		$criteria->limit = 50;
		$model = SocialNetwork::model()->findAll($criteria);

		return $model;
	}

	/*
	Define la entidad de acuerdo a una clave
	*/
	public function definitEntidad($key)
	{
		$claves = array(
			't' => 'tournament',
			'm' => 'tournament_match'
		);

		return $claves[$key];
	}

	/*
	Define el redireccionamiento despues de realizar una publicacion
	*/
	public function definirVista($entidad,$id)
	{
		$vista = '';

		if($entidad == 'tournament')
		{
			if($id != 0)
				$vista = 'view';
			else
				$vista = 'index';
		}
		else if($entidad == 'match')
		{
			$vista = 'partido';
		}

		return $vista;
	}
}
