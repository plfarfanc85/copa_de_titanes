<?php 
Yii::setPathOfAlias('gadminemailaction',dirname(__FILE__));
class GAdminEmail extends CWidget
{
	public $id;
	public $model;
	public $formAction=array("email");
	public $searchForm="#search-form";
	public function init()
	{
		Yii::import("gadminemailaction.models.SendForm");
		$this->registerScript();
		$sendForm=new SendForm;
		$sendForm->subject="Envío de registros tabla [".get_class($this->model)."]";
		$this->render("mailForm",array('sendForm'=>$sendForm));
	}

	public function registerScript()
	{
		$path="";
		if(Yii::app()->urlManager->urlFormat!=='path')
		{
			$path="
			indice=url.indexOf('&');
			url=url.substr(indice, url.length);
			url=$('#email-form').attr('action')+url;
			";
		}
		//Send mail
		Yii::app()->clientScript->registerScript("mail","
			jQuery('#{$this->id}').attr('data-toggle','modal');
			jQuery('#{$this->id}').attr('data-target','#sendMail');

			jQuery('#emailGo').live('click',function(e) {
				url=$('{$this->searchForm}').serialize();
				url=$('#email-form').attr('action')+'?'+url;
				{$path}
				  $('#email-form').attr('action', url);
				  $('#email-form').attr('target', this.target=='_blank' ? '_blank' : null);
				  $('#email-form').trigger('submit');
			});
		");
	}
}