<?php
$this->breadcrumbs=array(
	'Accion Ues'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista de UEL asociadas', 'url'=>array('index')),
	array('label'=>'Ver UEL asociada', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Actualizar UEL asignada #<?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('accionUe/view',array('id'=>$model->codigo, 'accion'=>$accion,'proyecto'=>$proyecto))); ?>