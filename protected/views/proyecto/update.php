<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Proyecto', 'url'=>array('index')),
	array('label'=>'Create Proyecto', 'url'=>array('create')),
	array('label'=>'View Proyecto', 'url'=>array('view', 'id'=>$model->codigo)),
	array('label'=>'Manage Proyecto', 'url'=>array('admin')),
);
?>

<h1>Actualizar Proyecto <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view', array('id'=>$model->codigo))); ?>