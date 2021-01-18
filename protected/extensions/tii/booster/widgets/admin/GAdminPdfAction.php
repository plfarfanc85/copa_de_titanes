<?php 
class GAdminPdfAction extends CAction 
{
	public $modelName;
	public $modelView;
	public $scenario='search';
	public function run()
	{
		if($this->modelName===null)
			throw new CException("El modelo y la vista para el pdf son requeridos.");
		if(isset($_GET['Pdf']))
		{
			$m=$this->modelName;
			$modelSearch= new $m($this->scenario);
			$modelSearch->unsetAttributes();  // clear any default values
			if(isset($_GET[$this->modelName]))
				$modelSearch->attributes=$_GET[$this->modelName];
			if($this->modelView===null)
				echo $this->render('pdf',array('model'=>$modelSearch));
			else	
				$this->controller->renderPartial($this->modelView,array('model'=>$modelSearch));
		}
		else
			throw new CHttpException(404,"La pagina no existe.");
	}

	
	/**
	 * render
	 * Renderiza la vista correspondiente a cada correo
	 * la cual se ubica en la carpeta components/flujos/views
	*/
	public function render($view,$data)
	{
		$class=new ReflectionClass(get_class($this));
		$viewFile = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view .'.php';
		extract($data);
		ob_start();
		ob_implicit_flush(false);
		include($viewFile);
		return ob_get_clean();
	}	
}