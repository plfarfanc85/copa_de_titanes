<?php

/**
 * This is the model class for table "historical".
 *
 * The followings are the available columns in table 'historical':
 * @property string $id
 * @property string $action
 * @property string $comments
 * @property string $table_name
 * @property integer $table_id
 * @property integer $rrhh_id
 * @property string $action_date
 */
class Historical extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Historico the static model class
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
		return 'historical';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comments,action,', 'required'),
			array('rrhh_id, table_id', 'numerical', 'integerOnly'=>true),
			array('action, table_name', 'length', 'max'=>50),
			array('id, comments, actions, table_name, table_id, rrhh_id, action_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'userRrhh' => array(self::BELONGS_TO, 'UserRrhh', 'rrhh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'action' => 'Accion',
			'comments' => 'Comentario',
			'table_name' => 'Entidad',
			'table_id' => 'Entidad',
			'rrhh_id' => 'Usuario',
			'action_date' => 'Fecha Hora',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('table_id',$this->table_id);
		$criteria->compare('rrhh_id',$this->rrhh_id);
		$criteria->compare('action_date',$this->action_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}