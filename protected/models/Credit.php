<?php

class Credit extends CActiveRecord
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
		return 'credit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("comments,player_id,date_import,state","required"),
			array("amount","validarMonto"),
			array("amount,path,rrhh_id","safe"),
			array('amount,player_id,rrhh_id,state', 'numerical', 'integerOnly'=>true),
			array('amount,comments,player_id,date_import,rrhh_id,state', 'safe', 'on'=>'search'),
		);
	}

	/*
	Validar el monto de aprovación
	*/
	public function validarMonto($attribute,$params)
	{
		if($this->attributes['amount'] > Yii::app()->params['maxcreditsbuy'])
			$this->addError($attribute,'Supera el máximo de compra de creditos.');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(Self::BELONGS_TO,'Player','player_id'),
			'rrhh'=>array(Self::BELONGS_TO,'UserRrhh','rrhh_id'),
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
		$criteria->compare('t.player_id',$this->player_id,true);
		$criteria->compare('t.state',$this->state);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}


	public function getState()
	{
		$list = array(
			0=>'Anulado',
			1=>'Aprobado',
			2=>'Pendiente'
			);

		return $list[$this->state];
	}

	public function getStateLabel()
	{
		$list =  array(
			0=>'<span class="label label-danger">Anulado</span>',
			1=>'<span class="label label-success">Aprobado</span>',
			2=>'<span class="label label-warning">Pendiente</span>'
			);

		return $list[$this->state];
	}

	
	public function getTotal()
	{
		$sql = 'SELECT sum(amount) total
				FROM credit
				WHERE player_id = '.Yii::app()->user->id.' and state = 1
		';

		return number_format(Yii::app()->db->createCommand($sql)->queryScalar(),0,".",".");
	}

	public function getDateFormat()
	{
		$fecha = date_create($this->date_import);
		return $fecha->format('d/m/Y');
	}

	public function getOpciones()
	{
		$opciones = '';

		if($this->state == 2)
		{
			$opciones .= '<button href="#myModalAprobar" facid="'.$this->id.'" class="btn btn-primary btn-xs m-r-5 apr" data-toggle="modal">Aprobar</button> ';
			$opciones .= CHtml::link("Anular",Yii::app()->createUrl("pantheon/credits/cancel",array("id"=>$this->id)), array('class'=>'btn btn-danger btn-xs m-r-5','confirm' => 'Seguro que desea anular la solicitud?')) . " ";      
		}	
		else if($this->state == 0)
		{

		}

		return $opciones;
	}
	
}
