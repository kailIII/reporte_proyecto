<?php
	//PHP 5.4+
	/*if (session_status() == PHP_SESSION_NONE)
	{
	    session_start();
	}*/
	// PHP 5.3
	if(session_id() == '')
	{
		session_start();
	}

	$_SESSION['nombreBd']=$_POST['base_datos'];
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;
?>