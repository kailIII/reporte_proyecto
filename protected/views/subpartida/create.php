<?php
$this->breadcrumbs=array(
	'Subpartidas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista de Subpartida', 'url'=>array('index')),
);
?>

<h1>Crear Subpartida</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('subpartida/index')); ?>