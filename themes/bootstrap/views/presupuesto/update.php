<?php
$this->breadcrumbs=array(
	'Presupuestos'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Presupuesto','url'=>array('index')),
	array('label'=>'Create Presupuesto','url'=>array('create')),
	array('label'=>'View Presupuesto','url'=>array('view','id'=>$model->codigo)),
	array('label'=>'Manage Presupuesto','url'=>array('admin')),
);
?>

<h1>Update Presupuesto <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>