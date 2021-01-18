<?php

class TournamentGroupPosition extends CActiveRecord
{
	public $playerInfo;
	public $consola;
	public $coordinador;

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
		return 'tournament_group_position';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array("player_id,tournament_group_id,point,position","required"),
			array('player_id,tournament_group_id,point,position', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'player'=>array(self::BELONGS_TO,'Player','player_id'),
			'tournamentGroup'=>array(self::BELONGS_TO,'TournamentGroup','tournament_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=&gt;label)
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}#

	/*
	Recalcula las posiciones despues de haber finalizado un partido
	A - Mayor número de puntos obtenidos en todos los partidos de grupo
	*/
	public function calculatePosition()
	{
		$complex = 0; //variable bandera para validar si se hace deducción de posición compleja - por gf,gc, pg, pp
		$positions = array();
		$positionsOV = array(); //Estension de la tabla Position dependiendo del tipo de juego - TournamentPosition....
		$j = 0;
		$gameType_id = $this->tournamentGroup->phase->session->tournament->game->gametype->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition('tournament_group_id = '.$this->tournament_group_id);
		$criteria->order = "position ASC";
		#$groupPosition = TournamentGroupPosition::model()->findAll('tournament_group_id = :g',array(':g'=>$this->tournament_group_id));
		$groupPosition = TournamentGroupPosition::model()->findAll($criteria);
		$total = count($groupPosition);
		$moment = 0; // variable que guarda posicion momentanea
		foreach ($groupPosition as $key => $value) 
		{
			$positions[] = array('id'=>$value->id,'puntos'=>$value->point,'posicion'=>$value->position,'player_id'=>$value->player_id); 

			// Si es Futbol, se decide por determinados criterios
			if($gameType_id == 1)
			{
				$groupPositionsSoccer = TournamentGroupPositionSoccer::model()->find('tournament_group_position_id = ?',array($value->id));
				$positionsOV[] = array('id'=>$value->id,'gf'=>$groupPositionsSoccer->gf,'gc'=>$groupPositionsSoccer->gc,'dg'=>$groupPositionsSoccer->dg,'pj'=>$groupPositionsSoccer->pj,'pg'=>$groupPositionsSoccer->pg,'pe'=>$groupPositionsSoccer->pe,'pp'=>$groupPositionsSoccer->pp) ;
			}
		}
		#echo '<pre>'.print_r($positionsOV,true).'</pre>';
		#echo '<pre>'.print_r($positions,true).'</pre>';die;
		#echo $positions[3]['puntos'];die;
		#echo $total;die;	
		//Eeduccion de posicion sencilla
		//Ordenamiento Sort
		for ($z=1; $z <= 2; $z++) 
		{
			for ($j=0; $j < $total; $j++) 
			{
				for ($i=0; $i < $total; $i++)
				{
					if($i!=$j)
					$positions = $this->calculatePositionValidate($positions,$positionsOV,$i,$j);
				} 
			}	
		}	

		//El primero debe tambien llevar la batuta
		#for ($i=1; $i < $total; $i++) 
		#	$positions = $this->calculatePositionValidate($positions,$positionsOV,$i,0);

		$bandera = 1;
		foreach ($positions as $key => $value) {
			$model = TournamentGroupPosition::model()->findByPk($value['id']);
			$model->position = $value['posicion'];
			if(!$model->save())
				$bandera = 0;
		}

		return $bandera;

	}

	public function calculatePositionValidate($positions,$positionsOV,$i,$j)
	{
		// A - Mayor número de puntos obtenidos en todos los partidos de grupo
		if($positions[$j]['puntos'] > $positions[$i]['puntos'])
		{
			$positions = $this->changuePosition($positions,$i,$j);
			#echo '<pre>'.print_r($positions,true).'</pre>';die;
		}else if($positions[$j]['puntos'] < $positions[$i]['puntos'])
		{
			$positions = $this->changuePositionReverse($positions,$i,$j);
			#echo '<pre>'.print_r($positions,true).'</pre>';die;
		}
		else if($positions[$j]['puntos'] == $positions[$i]['puntos'])	
		{
			#echo $positions[$j]['puntos'].' '.$positions[$i]['puntos'];die;
			#die;
			$positions = $this->calculatePositionComplex($positions,$positionsOV,$i,$j); //Validacion por GF, GC, PG, PP ...
		}	

		return $positions;
	}	

	/*
	Deduccion de posicion compleja

 	 	B - Diferencia de goles en todos los partidos de grupo;
		C - Mayor número de goles marcados en los encuentros de grupo
	  	
	  	Si dos o más equpos siguen igualados conforme al criterio arriba mencionado, su clasificación se determinará de la siguiente forma: 

	  	D - Mayor número de puntos obtenidos en los partidos de grupo;
	  	E - Diferencia de goles en los partidos de grupo;
	  	F - Mayor número de goles marcados en los encuentros de grupo;
	*/
	public function calculatePositionComplex($positions,$positionsOV,$i,$j)
	{
		#echo $i.' '.$j; die;
		$id_1 = $positions[$i]['id'];	
		$id_2 = $positions[$j]['id'];	
		
		$id_1_e = $positionsOV[$i]['id'];	
		$id_2_e = $positionsOV[$j]['id'];	
		#echo $id_1.' '.$id_1_e.' '.$id_2.' '.$id_2_e;die;
		// Validar ids de las 2 tablas
		if($id_1 != $id_1_e or $id_2 != $id_2_e)
			return array('error'=>1);

		#echo ($positionsOV[$j]['dg'] > $positionsOV[$i]['dg'])?1:0;die;
		#echo $positionsOV[$j]['dg'].' '.$positionsOV[$i]['dg'];die;
		#echo '<pre>'.print_r($positionsOV,true).'</pre>';die;
		#echo '<pre>'.print_r($positionsOV[$j],true).'</pre>';
		#echo '<pre>'.print_r($positionsOV[$i],true).'</pre>';die;

		// B - Diferencia de goles en todos los partidos de grupo;
		if($positionsOV[$j]['dg'] > $positionsOV[$i]['dg'])
			$positions = $this->changuePosition($positions,$i,$j);
		else if($positionsOV[$j]['dg'] == $positionsOV[$i]['dg'])
		{
			// C - Mayor número de goles marcados en los encuentros de grupo		
			if($positionsOV[$j]['gf'] > $positionsOV[$i]['gf'])
				$positions = $this->changuePosition($positions,$i,$j);
			else if($positionsOV[$j]['gf'] == $positionsOV[$i]['gf'])
			{
				// Si dos o más equpos siguen igualados conforme al criterio arriba mencionado, su clasificación se determinará de la siguiente forma: 
  				// D - Mayor número de puntos obtenidos en los partidos de grupo;
  				// E - Diferencia de goles en los partidos de grupo;
  				// F - Mayor número de goles marcados en los encuentros de grupo;
  				$positions = $this->calculatePositionIgualPoints($positions,$positionsOV,$i,$j);
			}
		}	
		
		return $positions;

	}	

	private function changuePosition($positions,$i,$j)
	{
		#echo '<pre>'.print_r($positions,true).'</pre>'.'<br>'.$i.' '.$j;die;
		if($positions[$j]['posicion'] > $positions[$i]['posicion'])
		{
			#$positions[$j]['posicion'] = $positions[$i]['posicion'];
			#for($n=$i;$n<$j;$n++)
			#	$positions[$n]['posicion']+=1;
			$m = $positions[$j]['posicion'];
			$positions[$j]['posicion'] = $positions[$i]['posicion'];
			$positions[$i]['posicion'] = $m;
			#echo '<pre>'.print_r($positions,true).'</pre>';die;	
		}	
		return $positions;
	}

	private function changuePositionReverse($positions,$i,$j)
	{
		#echo '<pre>'.print_r($positions,true).'</pre>'.'<br>'.$i.' '.$j;die;
		if($positions[$j]['posicion'] < $positions[$i]['posicion'])
		{
			#$positions[$j]['posicion'] = $positions[$i]['posicion'];
			#for($n=$i;$n<$j;$n++)
			#	$positions[$n]['posicion']+=1;
			$m = $positions[$j]['posicion'];
			$positions[$j]['posicion'] = $positions[$i]['posicion'];
			$positions[$i]['posicion'] = $m;
			#echo '<pre>'.print_r($positions,true).'</pre>';die;	
		}	
		return $positions;
	}

	// Si dos o más equpos siguen igualados conforme al criterio arriba mencionado, su clasificación se determinará de la siguiente forma: 
	// D - Mayor número de puntos obtenidos en los partidos de grupo;
	// E - Diferencia de goles en los partidos de grupo;
	// F - Mayor número de goles marcados en los encuentros de grupo;
	private function calculatePositionIgualPoints($positions,$positionsOV,$i,$j)
	{
		//return $positions;
		$ids_player_arreglo = array();
		$ids = array();
		$id = 0;
		$ganados1 = 0;
		$ganados2 = 0;
		$diferenciagoles = 0;
		$diferenciagolesArr = array();

		// Consultar los partidos entre los 2 jugadores
		array_push($ids_player_arreglo,$positions[$i]['player_id']);
		array_push($ids_player_arreglo,$positions[$j]['player_id']);

		$separado_comas_ids_player = "'".implode("','",$ids_player_arreglo)."'";				

		$criteria = new CDbCriteria;
		$criteria->select = "tmd.tournament_match_id id";
		$criteria->join = "
					INNER JOIN tournament_match_detail tmd ON t.id = tmd.tournament_match_id
					";
		$criteria->condition = "
				t.tournament_group_id = ".$this->tournament_group_id." and t.state = 3 and tmd.player_id in (".$separado_comas_ids_player.")";

		$criteria->order = 't.id';
		
		$usuarios = CActiveRecord::model('TournamentMatch')->findAll($criteria);	

		// Como la consulta vota todos los partidos del usuario del grupo, entonces ahora hay que hacer un filtro para que solo nos muestre los partidos entre los 2 jugadores.
		#echo var_dump($usuarios);die;
		if($usuarios)
		{
			foreach ($usuarios as $key => $value) 
			{
				#echo $value->id.' ';
				#echo $key;
				if($key!=0)
				{
					if($value->id == $id)
					$ids[]=$value->id;	
				}
				$id = $value->id;
			}	
			#die;
			// Teniendo los ids de los partidos, ahora si buscamos los partidos de los 2 jugadores
			#echo '<pre>'.print_r($ids,true).'</pre>';die;
			if(!empty($ids))
			{
				foreach ($ids as $key => $value) 
				{
					$match = TournamentMatchDetail::model()->findAll('tournament_match_id = ?',array($value));	
					$puntos = array();
					foreach ($match as $key => $value2) {
						// D - Mayor número de puntos obtenidos en los partidos de grupo;
						// E - Diferencia de goles en los partidos de grupo;
						// F - Mayor número de goles marcados en los encuentros de grupo;
						$puntos[$value2->player_id] = $value2->point;

						if($value2->player_id == $positions[$j]['player_id'])
							$diferenciagoles += $value2->point;
						else if($value2->player_id == $positions[$j]['player_id'])
							$diferenciagoles -= $value2->point;
					}

					if($puntos[$positions[$i]['player_id']]>$puntos[$positions[$j]['player_id']])
						$ganados1 += 1;
					else if($puntos[$positions[$i]['player_id']]<$puntos[$positions[$j]['player_id']])
						$ganados2 += 1;
				}

				if( $ganados2 > $ganados1 )
					$positions = $this->changuePosition($positions,$i,$j);
				else if( $ganados2 == $ganados1 )
				{
					if($diferenciagoles>0)
						$positions = $this->changuePosition($positions,$i,$j);
				}
			}
				
		}	
				
		
		return $positions;
	}


}
