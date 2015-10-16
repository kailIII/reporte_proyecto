<?php
$this->breadcrumbs=array(
	'Respaldos'=>array('default/index'),
	'Restaurar',
);?>
<h1>Restaurar</h1>

<p>
	<?php if(isset($error)) echo $error; else echo 'Listo';?>
</p>

<p> <?php echo CHtml::link('Volver', CController::createUrl('default/index'))?></p>

