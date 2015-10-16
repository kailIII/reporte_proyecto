<?php
$this->breadcrumbs=array(
	'Presupuestos'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'List Presupuesto','url'=>array('index')),
	array('label'=>'Create Presupuesto','url'=>array('create')),
	array('label'=>'Update Presupuesto','url'=>array('update','id'=>$model->codigo)),
	array('label'=>'Delete Presupuesto','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Presupuesto','url'=>array('admin')),
);
?>

<h1>View Presupuesto #<?php echo $model->codigo; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'codigo_accion',
		'presupuesto',
		'utilizado',
		'fecha_hora',
	),
)); ?>
