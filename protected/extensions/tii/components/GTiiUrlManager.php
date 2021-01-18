<?php
class GTiiUrlManager extends CUrlManager
{
	/**
		use for GTranslate 
	*/
	public function createUrl($route,$params=array(),$ampersand='&')
	{
        if (!isset($params['lg']))
        	$params['lg']=Yii::app()->language;
    	return parent::createUrl($route,$params,$ampersand);
	}
}