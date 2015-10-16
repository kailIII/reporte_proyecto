<?php
$this->breadcrumbs=array(
	'Accion Ues'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de UEL asociadas', 'url'=>array('index')),
	array('label'=>'Actualizar UEL asociada', 'url'=>array('update', 'id'=>$model->codigo,'accion'=>$accion,'proyecto'=>$proyecto)),
	array('label'=>'Eliminar UEL asociada', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo,'accion'=>$accion,'proyecto'=>$proyecto),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Ver UEL asignada #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		array('label'=>'Acción','value'=>Acciones::model()->findByPk($model->codigo_accion)->accion),
		array('label'=>'Unidad Ejecutora','value'=>UnidadEjecutora::model()->findByPk($model->codigo_ue)->denominacion)
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('accionUe/index',array('accion'=>$accion,'proyecto'=>$proyecto))); ?>