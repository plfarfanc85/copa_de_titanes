<?php


class Player extends CActiveRecord
{
	public $reemail;
	public $conditions;	
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
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dni,mobile,city_id,path', 'safe'),
			array('username, password, email, surname, name, state, profile,state', 'required'),

			#array('dni', 'length', 'max'=>15),
			array('dni','numerical','integerOnly'=>true),
			array('username', 'length', 'max'=>30),
			array('password, email', 'length', 'max'=>255),
			array('surname, name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, dni, email, surname, name, state, profile', 'safe', 'on'=>'search'),
			array('username, password, dni, email, surname, name, state, profile', 'required', 'on'=>'register'),
			array('email', 'compare', 'compareAttribute'=>'reemail', 'on'=>'register'),
			array('username', 'validationUsername', 'on'=>'register'),
			array('dni', 'validationDni', 'on'=>'register'),
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
			'city'=>array(self::BELONGS_TO,'City','city_id'),
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
			'city_id' => 'Ciudad',
			'mobile' => 'Celular',
			'name' => 'Nombre',
			'surname' => 'Apellido',
			
		);
	}

	public function validationUsername($attribute,$params)
	{
		#echo $this->$attribute;die;
		$model = Player::model()->find('username = ?',array($this->$attribute));

		if($model)
			$this->addError($attribute, 'El usuario ya existe.');
	}

	public function validationDni($attribute,$params)
	{
		#echo $this->$attribute;die;
		$model = Player::model()->find('dni = ?',array($this->$attribute));

		if($model)
			$this->addError($attribute, 'El documento ya existe.');
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

	public function getNames()
	{
		return $this->name.' '.$this->surname.' - <span style="color:grey">'.$this->username.'</span>';
	}

	public function getNamesWU()//Sin Username
	{
		return $this->name.' '.$this->surname;
	}

	/*
	Dashboard - total de jugadores registrados
	*/
	public function getTotal()
	{
		$model = Player::model()->findAll('state = 1');
		#echo '<pre>'.print_r($model,true).'</pre>';die;
		return count($model);
	}

	/*
	Jugadores que estan en linea 
	*/
	public function getTotalEnLinea()
	{
		$model = Player::model()->findAll('state = 1 and login = 1');
		#echo '<pre>'.print_r($model,true).'</pre>';die;
		return count($model);	
	}	

	/*
	Actualiza el estado del jugador en linea
	*/
	public function updateEnLinea($action)
	{
		$user = Player::model()->findByPk(Yii::app()->user->id);

		if($action == 'login')
			$user->login = 1;
		else if($action == 'logout')
			$user->login = 0;

		$user->save();
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