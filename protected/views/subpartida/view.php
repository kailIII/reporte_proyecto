<?php
$this->breadcrumbs=array(
	'Subpartidas'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Subpartida', 'url'=>array('index')),
	array('label'=>'Actualizar Subpartida', 'url'=>array('update', 'id'=>$model->codigo)),
	//array('label'=>'Eliminar Subpartida', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Ver Subpartida #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'partida',
		'ge',
		'es',
		'se',
		'descripcion',
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('subpartida/index')); ?>