<?php
$this->breadcrumbs=array(
	'Unidad Ejecutoras'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'List UnidadEjecutora', 'url'=>array('index')),
	array('label'=>'Create UnidadEjecutora', 'url'=>array('create')),
	array('label'=>'View UnidadEjecutora', 'url'=>array('view', 'id'=>$model->codigo)),
	array('label'=>'Manage UnidadEjecutora', 'url'=>array('admin')),
);
?>

<h1>Update UnidadEjecutora <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>