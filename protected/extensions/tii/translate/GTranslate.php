<?php
class GTranslate extends CApplicationComponent
{
	public $sendMailNeed;

	private $_assetsUrl;
	public function init()
	{
		Yii::app()->messages->onMissingTranslation=array($this,'getNeed');
		Yii::app()->language=isset($_GET['lg'])?$_GET['lg']:Yii::app()->language;
		parent::init();
	}

	public function builtMenu()
	{
		return array(
            array('label'=>CHtml::image($this->getAssetsUrl()."/b-es.png")." ".Yii::t('GTranslate.app','Spanish'), 'url'=>$this->createMultilanguageReturnUrl('es')),
            array('label'=>CHtml::image($this->getAssetsUrl()."/b-en.png")." ".Yii::t('GTranslate.app','English'), 'url'=>$this->createMultilanguageReturnUrl('en')),
        );
	}

	public function createMultilanguageReturnUrl($lang='en')
	{
        $arr = array('lg'=>$lang);
        if (count($_GET)>0){
            $arr = $_GET;
            $arr['lg']= $lang;
        }
    	return Yii::app()->controller->createUrl('', $arr);
	}

	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
			$this->_assetsUrl=Yii::app()->assetManager->publish(Yii::getPathOfAlias('translate.assets'));
		return $this->_assetsUrl;
	}

	public function getNeed($event)
	{
		$text="";
		$text.= " Language: {$event->language} <br>";
		$text.= " Category: {$event->category} <br>";
		$text.= " Menssage: {$event->message} <br>";
		if($this->sendMailNeed!==null)
			mail($this->sendMailNeed,'Necesito traduccion!!!',$text);
		Yii::log($text,'info','ext.GTranslate.need');
	}
}