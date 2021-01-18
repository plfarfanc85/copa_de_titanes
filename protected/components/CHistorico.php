<?php
class CHistorico extends CApplicationComponent
{

	/**
	* Inserta registro de una acción
	* @param Model $model
	* @param Integer $action accion realizada
	* @param String $comments descripción de la acción
	*/
	public function set($model, $action="", $comments="",$rrhh_id=null)
	{
		$modelh = new Historical;
		$modelh->action = $action;
		$modelh->comments = $comments;
 		$modelh->table_name = $model->tableName();
 		$modelh->table_id = $model->id;
 		$modelh->rrhh_id = $rrhh_id!==null?$rrhh_id:Yii::app()->user->id;
 		$modelh->action_date = date('Y-m-d H:i:s');

		if($modelh->save())
			return true;
		else
			return false;
	}
	
}