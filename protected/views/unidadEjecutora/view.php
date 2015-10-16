<?php
$this->breadcrumbs=array(
	'Unidad Ejecutoras'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'List UnidadEjecutora', 'url'=>array('index')),
	array('label'=>'Create UnidadEjecutora', 'url'=>array('create')),
	array('label'=>'Update UnidadEjecutora', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Delete UnidadEjecutora', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UnidadEjecutora', 'url'=>array('admin')),
);
?>

<h1>View UnidadEjecutora #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'codigo_uel',
		'denominacion',
	),
)); ?>
