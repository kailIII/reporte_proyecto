<?php
$this->breadcrumbs=array(
	'Materiales y Servicios'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Materiales/Servicios', 'url'=>array('index')),
	array('label'=>'Actualizar Materiales/Servicios', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Eliminar Materiales/Servicios', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Buscar Materiales/Servicios', 'url'=>array('admin')),
);
?>

<h1>Ver Materiales/Servicios #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'descripcion',
		'precio1',
		array('label'=>'Subpartida','value'=>Subpartida::model()->findByPk($model->subpartida)->descripcion),
		array('label'=>'Unidad de Medida','value'=>UnidadMedida::model()->findByPk($model->unidad_medida)->unidad_medida),
		array('label'=>'Presentación','value'=>Presentacion::model()->findByPk($model->presentacion)->presentacion),
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('materialesServicios/index')); ?>