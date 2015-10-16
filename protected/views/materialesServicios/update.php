<?php
$this->breadcrumbs=array(
	'Materiales y Servicios'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista de Materiales/Servicios', 'url'=>array('index')),
	array('label'=>'Crear Materiales/Servicios', 'url'=>array('create')),
	array('label'=>'Ver Materiales/Servicios', 'url'=>array('view', 'id'=>$model->codigo)),
	array('label'=>'Buscar Materiales/Servicios', 'url'=>array('admin')),
);
?>

<h1>Actualizar Materiales/Servicios <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('materialesServicios/view',array('id'=>$model->codigo))); ?>