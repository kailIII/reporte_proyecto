<?php
$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Partidas', 'url'=>array('index')),
	array('label'=>'Actualizar Partida', 'url'=>array('update', 'id'=>$model->codigo)),
	//array('label'=>'Eliminar Partida', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Ver Partida #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'partida',
		'descripcion',
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('partida/index')); ?>