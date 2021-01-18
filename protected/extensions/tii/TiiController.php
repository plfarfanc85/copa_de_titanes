<?php
class TiiController extends CExtController
{
	public function actionIndex()
	{
		$data=Yii::app()->tii->load();
		$dataNew=Yii::app()->tii->load(true);
		$this->render("index",array('data'=>$data,'dataNew'=>$dataNew));
	}
}