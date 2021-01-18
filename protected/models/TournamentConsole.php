<?php

class TournamentConsole extends CActiveRecord
{
	public $names;
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
		return 'tournament_console';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("name,console_id,state","required"),
			array('name,console_id,state', 'safe', 'on'=>'search'),
			array('console_id,state', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'consoleType'=>array(self::BELONGS_TO,'Consoles','console_id'),
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
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getList()
	{
		$model=TournamentConsole::model()->findAll(array(
			"order"=>"name",
			"condition"=>'state=1',
		));
		return CHtml::listData($model,"id","name");
	}

}
