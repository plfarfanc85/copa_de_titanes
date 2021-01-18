<?php
/**
	example
	in controller
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		    'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
        );

in the view 
<?php
$this->widget('xupload.XUpload', array(
    'url' => Yii::app()->createUrl("site/upload"),
    'model' => $model,
    'attribute' => 'file',
    'multiple' => true,
));
?>

and in the action before render tha view
// Yii::import("xupload.models.XUploadForm");
// or auto import        
$model = new XUploadForm;
$this -> render('index', array('model' => $model, ));
*/
return array(
	'aliases' => array(
	    //assuming you extracted the files to the extensions folder
	    'xupload' => dirname(__FILE__),
	),
	'import'=>array(
		'xupload.models.XUploadForm',
	),
);