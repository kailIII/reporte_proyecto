<?php
$this->breadcrumbs=array(
	'Unidad Ejecutoras'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UnidadEjecutora', 'url'=>array('index')),
	array('label'=>'Manage UnidadEjecutora', 'url'=>array('admin')),
);
?>

<h1>Create UnidadEjecutora</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>