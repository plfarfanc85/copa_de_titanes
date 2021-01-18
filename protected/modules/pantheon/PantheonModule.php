<?php

class PantheonModule extends CWebModule
{
	public function init()
	{
		 $this->layoutPath = Yii::getPathOfAlias('pantheon.views.layouts');
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'pantheon.models.*',
			'pantheon.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			/*
			$url = Yii::app()->createUrl('site/index');
			// Valida que el modulo esté habilitado para el portal, de lo contrario lo envía al inicio
			if(Yii::app()->user->getState('olimpico') and (Yii::app()->user->getState('perfil') == "admin" or Yii::app()->user->getState('perfil') == "super") )
				return true;
			else
				Yii::app()->request->redirect($url);
				*/
			return true;	
		}
		else
			return false;
	}
}
