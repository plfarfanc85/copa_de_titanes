<?php

class TorneosModule extends CWebModule
{
	public function init()
	{
		 $this->layoutPath = Yii::getPathOfAlias('torneos.views.layouts');
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'torneos.models.*',
			'torneos.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// Valida que el modulo esté habilitado para el portal, de lo contrario lo envía al inicio
			#if(Yii::app()->config->get('claro_gestion_ganadores'))
				return true;
			#else
			#	Yii::app()->request->redirect('/');
		}
		else
			return false;
	}
}
