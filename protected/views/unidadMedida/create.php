<?php
$this->breadcrumbs=array(
	'Unidad Medidas'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Lista Unidad Medida', 'url'=>array('index')),
);
?>

<h1>Crear Unidad Medida</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br/>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('unidadMedida/index')); ?>