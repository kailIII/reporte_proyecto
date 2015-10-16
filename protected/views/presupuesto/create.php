<?php
$this->breadcrumbs=array(
	'Presupuestos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Presupuesto','url'=>array('index')),
	array('label'=>'Manage Presupuesto','url'=>array('admin')),
);
?>

<h1>Create Presupuesto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>