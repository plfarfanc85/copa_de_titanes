<?php 
Yii::setPathOfAlias('gadminemailaction',dirname(__FILE__));
class GAdminEmailAction extends CAction 
{
	public $modelName;
	public $modelView;
	public $fromMail;
	public $scenario='search';
	public $redirectAction=array("admin");
	public function run()
	{
		if($this->modelName===null)
			throw new CException("El modelo y la vista para el mensaje son requeridos.");
		if($this->fromMail===null)
			$this->fromMail=Yii::app()->params['adminEmail'];
		if(isset($_POST['SendForm']))
		{
			Yii::import("gadminemailaction.models.SendForm");
			$model=new SendForm;
			$model->attributes=$_POST['SendForm'];
			if($model->validate())
			{
				$m=$this->modelName;
				$modelSearch= new $m($this->scenario);
				$modelSearch->unsetAttributes();  // clear any default values
				if(isset($_GET[$this->modelName]))
					$modelSearch->attributes=$_GET[$this->modelName];
				if($this->modelView===null)
				{
					$content="<table border=1>";
						$content.="<tr>";
						foreach ($modelSearch->attributeNames() as $keyCol => $column)
							$content.="<th style=\"background-color:#555;color:#FFF;\">".$modelSearch->getAttributeLabel($column)."</th>";
						$content.="</tr>";
					foreach ($modelSearch->findAll($modelSearch->search()->getCriteria()) as $key => $data)
					{
						
						$background=$key%2==0?" style=\"background-color:#F0F0F0;\"":"";
						$content.="<tr>";
						foreach ($modelSearch->attributeNames() as $keyCol => $column)
							$content.="<td".$background.">".$data->{$column}."</td>";
						$content.="</tr>";
					}
					$content.="</table>";
					$model->body.=$content;
				}else{
					$model->body.=$this->controller->renderPartial($this->modelView,array(
					'model'=>$modelSearch,
					'modelSend'=>$model,
					),true);
				}

				$name='=?UTF-8?B?'.base64_encode(Yii::app()->user->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$this->fromMail}>\r\n".
					"Reply-To: {$this->fromMail}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
				if($mail=mail($model->email,$subject,$model->body,$headers))
					Yii::app()->user->setFlash('success','<strong>OK!</strong> El mensaje ha sido enviado.');
				else
					Yii::app()->user->setFlash('error','<strong>Oops!</strong> No se envio el mensaje, revise su servidor de correo.');
				$this->controller->redirect($this->redirectAction);
			}
		}
	}
}