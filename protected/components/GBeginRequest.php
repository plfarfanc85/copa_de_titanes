<?php
class GBeginRequest
{
	public static function initLoad()
	{
		if(isset($_GET['clear_cache']))
		{
			Yii::app()->cache->flush();
			echo "cache Borrado";
		}
	}

	
}