<?php
$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Lista de Partidas', 'url'=>array('index')),
	array('label'=>'Buscar Partida', 'url'=>array('admin')),
);
?>

<h1>Crear Partida</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('partida/index')); ?>