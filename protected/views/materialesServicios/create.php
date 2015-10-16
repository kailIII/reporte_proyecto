<?php
$this->breadcrumbs=array(
	'Materiales y Servicios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista de Materiales/Servicios', 'url'=>array('index')),
	array('label'=>'Buscar Materiales/Servicios', 'url'=>array('admin')),
);
?>

<h1>Crear Materiales/Servicios</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('materialesServicios/index')); ?>