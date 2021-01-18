<?php
# Configuración en entorno de Desarrollo
if($_SERVER['REMOTE_ADDR'] == "::1")
{
	error_reporting(E_ALL);
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	# Core de Yii
	$yii=dirname(__FILE__).'/yii-1.1.11/framework/yii.php';
}else
	$yii=dirname(__FILE__).'/yii-1.1.11/framework/yii.php';

# Archivo de configuración principal
$config=dirname(__FILE__).'/protected/config/main.php';

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
