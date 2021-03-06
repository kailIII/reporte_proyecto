<?php
//PHP 5.4
/*if (session_status() == PHP_SESSION_NONE)
{
    session_start();
    $_SESSION['nombreBd'];
}*/
// PHP 5.3
if(session_id() == '')
{
    session_start();
    $_SESSION['nombreBd'];
}

if(!$_SESSION['nombreBd'] == '')
{
	// change the following paths if necessary
	$yii=dirname(__FILE__).'/../yii/framework/yii.php';
	//echo $yii; exit();
	$config=dirname(__FILE__).'/protected/config/main.php';

	// remove the following lines when in production mode
	//defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

	require_once($yii);
	  
	Yii::createWebApplication($config)->run();
}
else
{
	include('_index.php');
}

?>