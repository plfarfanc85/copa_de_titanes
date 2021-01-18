<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extendS CrudCode
{
	public function generateActiveRow($modelClass, $column,$span=5,$search=false)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}')";
		else if (stripos($column->dbType,'text') !== false && $search===false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>4, 'cols'=>50, 'class'=>'span{$span}'))";
		else if (stripos($column->dbType,'date') !== false)
		{
			$dateField=$search?"dateRangeRow":"datepickerRow";
			return "\$form->{$dateField}(\$model,'{$column->name}',array('class'=>'span{$span}'))";
		}
		else
		{
			if (preg_match('/(_id)$/i',$column->name))
				$inputField='dropDownListRow';
			else if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';
			if(preg_match('/(_id)$/i',$column->name))
				return "\$form->{$inputField}(\$model,'{$column->name}',array(''=>'Select',1=>'test Value')/*uncomment \$model->".rtrim($column->name,'_id')."Menu*/,array('class'=>'span{$span}'))";
			else if ($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span{$span}'))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span{$span}','maxlength'=>$column->size))";
		}
	}
}
