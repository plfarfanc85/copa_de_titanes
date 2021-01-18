<?php
class GHtml extends CHtml
{
    public static function imageUrl($nameImage)
	{
		if(Yii::app()->getTheme()!==null && file_exists(Yii::app()->getTheme()->getBasePath()."/images/$nameImage"))
			return Yii::app()->theme->baseUrl."/images/$nameImage";
		return Yii::app()->request->baseUrl."/images/new/$nameImage";
	}
        
	public static function imageAbsUrl($nameImage)
	{
		if(Yii::app()->getTheme()!==null && file_exists(Yii::app()->getTheme()->getBasePath()."/images/$nameImage"))
			return Yii::app()->request->getBaseUrl(true).Yii::app()->theme->baseUrl."/images/$nameImage";
		return Yii::app()->request->getBaseUrl(true)."/images/new/$nameImage";
	}
        
	public static function imageAbs($nameImage,$alt="",$htmlOptions=array())
	{
		return parent::image(self::imageAbsUrl($nameImage),$alt,$htmlOptions);
	}
        
	public static function image($nameImage,$alt="",$htmlOptions=array())
	{
		return parent::image(self::imageUrl($nameImage),$alt,$htmlOptions);
	}    
}