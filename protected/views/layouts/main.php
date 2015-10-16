<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Viewport para distintos dispositivos -->
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	
	<div id="header">
		<div id="banner"></div>
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Proyectos', 'url'=>array('/proyecto/index'), 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Presupuestos', 'url'=>array('/presupuesto/index'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->nivel==1),
				array('label'=>'Historial', 'url'=>array('site/historial'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->nivel==1),
				array('label'=>'Buscar Registros', 'url'=>array('reporte/admin'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->nivel==1),
				array('label'=>'Opciones','url'=>array('/site/opciones'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->nivel==1),				
				array('label'=>'Iniciar sesión', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Cerrar sesión ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>false
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php echo $content; ?>

	<div id="footer">
		<?php date_default_timezone_set("America/Caracas");	?> <!-- Definir el timezone -->
		Copyleft &copy; <?php echo date('Y'); ?> por MINPPPST.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>