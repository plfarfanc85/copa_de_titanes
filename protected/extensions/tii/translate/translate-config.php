<?php
return array(
	'aliases'=>array(
		'translate'=>dirname(__FILE__),
	),
	'preload'=>array('translate'),
	'components'=>array(
		'translate'=>array(
			'class'=>'translate.GTranslate',
		),
		'urlManager'=>array(
			'class'=>'tii.components.GTiiUrlManager',
			'rules'=>array(
				'<lg:\w{2,4}>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<lg:\w{2,4}>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<lg:\w{2,4}>/<controller:\w+>/<action:\w+>/<id:\d+>/<title:\w+>'=>'<controller>/<action>',
				'<lg:\w{2,4}>/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<lg:\w{2,4}>/<module:\w+>/<controller:\w+>/<action:\w+>/<id>'=>'<module>/<controller>/<action>',
				'<lg:\w{2,4}>/<module:\w+>/<controller:\w+>/<action:\w+>/<title>'=>'<module>/<controller>/<action>',
				'<lg:\w{2,4}>/<module_or_controller:\w+>'=>'<module_or_controller>',
			)
		),
	)
);