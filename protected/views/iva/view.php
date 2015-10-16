<?php
$this->breadcrumbs=array(
	'Ivas'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de IVA', 'url'=>array('index')),
	array('label'=>'Actualizar IVA', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Eliminar IVA', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Iva #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'iva',
	),
)); ?>
</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('iva/index')); ?>