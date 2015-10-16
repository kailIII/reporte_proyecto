<?php
	if (session_status() == PHP_SESSION_NONE)
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