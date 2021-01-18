<?php

class TournamentWinners extends CActiveRecord
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
		return 'tournament_winners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('tournament_id,percent,player_id,position,state', 'safe', 'on'=>'search'),
			array("tournament_id,percent,position,state","required"),
			array("player_id","safe"),
			array('tournament_id,player_id,percent,position,state', 'numerical', 'integerOnly'=>true),
			array('percent','ComprobarPorcentaje'),
			array('position','ValidarPosicion'),
		);
	}

	/*
	Validar que la suma de los porcentajes no supere al 100% de la bolsa de premios.
	*/
	public function ComprobarPorcentaje($attribute,$params)
	{
		$winners = TournamentWinners::model()->findAll('tournament_id = ?',array($this->attributes['tournament_id']));

		if($winners)
		{
			$total = 0; //Suma total de los porcentajes
			foreach ($winners as $key => $value) {
				$total += $value->percent;
			}
			$total += $this->attributes['percent'];

			if($total > 100)
				$this->addError($attribute,'El total de los porcentajes superan el 100%.');
		} 
	}

	/*
	Validar que la posicion no se vaya a duplicar
	*/
	public function ValidarPosicion($attribute,$params)
	{
		$posicion = TournamentWinners::model()->findAll('tournament_id = ? and position = ?',array($this->attributes['tournament_id'],$this->attributes['position']));

		if($posicion)
			$this->addError($attribute,'La posición ya existe.');	
	}	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(Self::BELONGS_TO,'Player','player_id')
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
		#$criteria->addCondition('t.estado != 2');
		
		$criteria->order = "t.position ASC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>$pages),
		));
	}

	public function getState()
	{
		$list = array(
			0=>'Inactivo',
			1=>'Activo',
			2=>'Finalizado'
			);

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

	public function getTestLabel()
	{
		$list =  array(
			1=>'<span class="label label-danger">Si</span>',
			0=>'<span class="label label-success">No</span>',
			);

		return $list[$this->test];
	}

	/*
	Dahsboard - torneos realizados
	*/
	public function getTotal()
	{
		$model = Tournament::model()->findAll('test = 0');

		return count($model);
	}

	/*
	Formato a la fecha de inicio del torneo para el dashboard del torneo
	*/
	public function getDateFormated()
	{
		$mesArray = array('01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic');
		$fecha = date_create($this->start_date);
		return $fecha->format('d').' de '.$mesArray[$fecha->format('m')];

	}


}
