<?php 
class GUrlClean extends CApplicationComponent 
{
	public $debug=true;
	
	/**
	 * @var boolean whether the log should be displayed in FireBug instead of browser window. Defaults to false.
	 */
	public $showInFireBug=false;

	/**
	 * @var boolean whether the log should be ignored in FireBug for ajax calls. Defaults to true.
	 * This option should be used carefully, because an ajax call returns all output as a result data.
	 * For example if the ajax call expects a json type result any output from the logger will cause ajax call to fail.
	 */
	public $ignoreAjaxInFireBug=true;

	/**
	 * @var boolean whether the log should be ignored in FireBug for Flash/Flex calls. Defaults to true.
	 * This option should be used carefully, because an Flash/Flex call returns all output as a result data.
	 * For example if the Flash/Flex call expects an XML type result any output from the logger will cause Flash/Flex call to fail.
	 * @since 1.1.11
	 */
	public $ignoreFlashInFireBug=true;
	public $data=array();

	public function init()
	{
		Yii::app()->urlManager->attachBehavior('forShow',array('class'=>'urlclean.GClearUrlManager'));

		if($this->debug)
		{

			// $this->data=array(
			// 	array('Mi mensage','niveleee ','categoria.je.je.je',time()),
			// 	array('Mi mensage 2','niveleee 2 ','categoria.je.je.je',time()),
			// );
			foreach (Yii::app()->urlManager->rules as $patern => $rule)
				$this->data[]=array($patern,CHtml::encode($rule),$rule,time());
			Yii::app()->onEndRequest=array($this,'render');
		}

		if(!file_exists(Yii::getPathOfAlias("webroot").DIRECTORY_SEPARATOR.".htaccess"))		
		{
			$fl=fopen(Yii::getPathOfAlias("webroot").DIRECTORY_SEPARATOR.".htaccess", "w+");
			fputs($fl,"Options +FollowSymLinks\n");
			fputs($fl,"IndexIgnore */*\n");
			fputs($fl,"RewriteEngine on\n");
			fputs($fl," \n");
			fputs($fl,"# if a directory or a file exists, use it directly\n");
			fputs($fl,"RewriteCond %{REQUEST_FILENAME} !-f\n");
			fputs($fl,"RewriteCond %{REQUEST_FILENAME} !-d\n");
			fputs($fl," \n");
			fputs($fl,"# otherwise forward it to index.php\n");
			fputs($fl,"RewriteRule . index.php\n");
			fputs($fl,"");
			fclose($fl);
		}
		parent::init();
	}


	/**
	 * Renders the view.
	 * @param string $view the view name (file name without extension). The file is assumed to be located under framework/data/views.
	 * @param array $data data to be passed to the view
	 */
	protected function render()
	{
		$data=$this->data;
		$app=Yii::app();
		$isAjax=$app->getRequest()->getIsAjaxRequest();
		$isFlash=$app->getRequest()->getIsFlashRequest();

		if($this->showInFireBug)
		{
			// do not output anything for ajax and/or flash requests if needed
			if($isAjax && $this->ignoreAjaxInFireBug || $isFlash && $this->ignoreFlashInFireBug)
				return;
			$view.='-firebug';
		}
		else if(!($app instanceof CWebApplication) || $isAjax || $isFlash)
			return;

		$viewFile=dirname(__FILE__).DIRECTORY_SEPARATOR.'show.php';
		include($viewFile);
	}
}