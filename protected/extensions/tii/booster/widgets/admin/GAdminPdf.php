<?php 
class GAdminPdf extends CWidget
{
	public $id;
	public $searchForm;
	public $formAction;
	
	public function init()
	{
		if($this->formAction===null)
			$this->formAction=Yii::app()->controller->createUrl("pdf");
		//pdf mail
		$path="";
		if(Yii::app()->urlManager->urlFormat!=='path')
		{
			$path="
			indice=url.indexOf('&');
			url=url.substr(indice, url.length);
			url='".$this->formAction."'+url;
			";
		}
		Yii::app()->clientScript->registerScript("pdf","
				jQuery('#{$this->id}').live('click',function(e) {
					url=$('{$this->searchForm}').serialize();
					url='".$this->formAction."?'+url;
					{$path}
				    window.location=url+'&Pdf=1';
				});
			");
	}
}