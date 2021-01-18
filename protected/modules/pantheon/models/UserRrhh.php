<?php


class UserRrhh extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSites the static model class
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
		return 'rrhh';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, dni, email, mobile, surname, name, state, profile', 'required'),
			array('dni', 'length', 'max'=>15),
			array('username,password, email', 'length', 'max'=>255),
			array('surname, name', 'length', 'max'=>35),
			array('mobile', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, dni, email, mobile, surname, name, state, profile', 'safe', 'on'=>'search'),
			#array('id, idSitio, documento, password, email, apellidos, nombres, genero, fecha_nacimiento, fecha_registro, direccion, telefono, ciudad, estado, celular, perfil', 'safe', 'on'=>'searchSolRegistro'),
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
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dni' => 'Documento',
			'name' => 'Nombre',
			'surname' => 'Apellido',
			'mobile' => 'Celular',
		);
	}

	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new GDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('dni',$this->dni,true);
		$criteria->compare('email',$this->email,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>40,
				'pageVar'=>'page',
			),
		));
	}

	public function getCoordinatorsTournament()
	{
		$coordinators = UserRrhh::model()->findAll('state = 1');
		$coordinatorsList = array();
		foreach ($coordinators as $key => $value) {
			$coordinatorsList[]=$value->id;
		}

		return $coordinatorsList;
	}

	public function stateList()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
		);

		return $list;
	}

	public function getState()
	{
		$list = $this->stateList();
		return $list[$this->state];
	}
	
}