<?php
return array(
	#'theme'=>'bootstrap-ubuntu',
	#'theme'=>'bootstrap-red',
	'aliases'=>array(
		'bootstrap'=>dirname(__FILE__),
	),
	'import'=>array(
		'bootstrap.db.schema.GDbCriteria',
		'bootstrap.components.editable.EditableSaver',
	),
	'preload'=>array('bootstrap'),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
	),
	'components'=>array(
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
			'responsiveCss'=>true,
			'coreCss'=>false,
		),
		'widgetFactory' => array(
			'widgets' => array(
				'TbDatePicker' => array(
					'options'=>array('format'=>'yyyy-mm-dd'),
				),
				'TbDateRangePicker' => array(
					'options'=>array('format'=>'yyyy/MM/dd'),
				),
				'TbPager'=>array(
		           'maxButtonCount'=>6,
		        ),
			),
		),
	),
);
