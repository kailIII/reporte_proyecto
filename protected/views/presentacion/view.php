<?php
$this->breadcrumbs=array(
	'Presentacions'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Presentación', 'url'=>array('index')),
	array('label'=>'Actualizar Presentación', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Eliminar Presentación', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Ver Presentación #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'presentacion',
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('presentacion/index')); ?>