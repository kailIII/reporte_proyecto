<?php
$this->breadcrumbs=array(
	'Reportes'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista de Registros', 'url'=>array('index')),
	array('label'=>'Ver Registro', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Actualizar Registro <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'value'=>$value,'accion'=>$accion,'proyecto'=>$proyecto)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('reporte/view',array('id'=>$model->codigo,'accion'=>$accion,'proyecto'=>$proyecto))); ?>