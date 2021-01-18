<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Copa de Titanes',
	'language' => 'es',
	'charset' => 'utf-8',
	'theme' => 'backend',

	'aliases'=>array(
		'widgets'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../widgets/',
		'bootstrap'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/tii/booster/',
	),

	// preloading 'log' component
	#'preload'=>array('bootstrap'),

	'onBeginRequest'=>array("GBeginRequest","initLoad"),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.db.schema.GDbCriteria',
	),

	'modules'=>array(
		'pantheon',
		'torneos',
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'loginUrl'=>array('torneos/usuario/login'),
			'allowAutoLogin'=>true,
		),

		'gemail'=>array(
			'class'=>'application.components.email.CGMailer',
			'Host' => 'n3plcpnl0004.prod.ams3.secureserver.net',
			'SMTPSecure' => 'tls',
			'SMTPAuth' => true,
			'Port' => 465,
			'Username' => 'info@copadetitanes.com',
			'Password' => '',
			'remit_name' => 'Copa de Titanes',
			'remit_email' => 'info@copadetitanes.com',
			'reply_name' => 'Pedro Farfan',
			'reply_email' => '',
		),

		// uncomment the following to enable URLs in path-format
		
		// uncomment the following to enable URLs in path-format
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'caseSensitive'=>true,
			'rules'=>array(
				'/'=>'/site/',
				'/escribenos'=>'/site/escribenos#',
				'<controller:\w+>'=>'/<controller>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'/<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		#'db'=>require(dirname(__FILE__).'/database.php'),
		'db'=>array(
			'class'=>'CDbConnection', 
			'connectionString' => YII_DEBUG?'mysql:dbname=pantheon;host=127.0.0.1':'mysql:dbname=pantheon;host=127.0.0.1',
			'emulatePrepare' => true,
			'username' => YII_DEBUG?'root':'',
			'password' => YII_DEBUG?'':'',
			'schemaCachingDuration' => (1), // 8 Dias	
			#'schemaCachingDuration' => (3600*24*8), // 8 Dias
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),
		
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
			'responsiveCss'=>false,
			'coreCss'=>false,
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		'cache'=>array(
		        'class' => 'CFileCache',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'historical'=>array(
		    'class'=>'application.components.CHistorico',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'info@copadetitanes.com',
		// maximun amount of credits that a user can buy
		'maxcreditsbuy'=>1000000,
	),
);
