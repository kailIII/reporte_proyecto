<?php
$this->breadcrumbs=array(
	'Presentacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Presentacion', 'url'=>array('index')),
	array('label'=>'Manage Presentacion', 'url'=>array('admin')),
);
?>

<h1>Create Presentacion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('presentacion/index')); ?>