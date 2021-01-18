<?php 
class GDbCriteria extends CDbCriteria
{
	public function addConditionCalendar($column,$value,$operator='AND')
	{
		if(!empty($value))
		{
			$date=explode(' - ', $value);
			$this->addBetweenCondition($column,strtr(trim($date[0]),array('/'=>'-')),strtr(trim($date[1]),array('/'=>'-')),$operator);
		}
		return $this;
	}
}