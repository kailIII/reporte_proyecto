<?php
$this->breadcrumbs=array(
	'Proyecto'=>array('proyecto/view','id'=>Proyecto::model()->findByAttributes(array('codigo'=>$proyecto))->codigo),
	'Accion '.$accion=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'Reportes'=>array('reporte/index','accion'=>$accion,'proyecto'=>$proyecto),
	$model->codigo
);

$this->menu=array(
	array('label'=>'Actualizar Registro', 'url'=>array('update', 'id'=>$model->codigo,'accion'=>$accion,'proyecto'=>$proyecto)),
	array('label'=>'Eliminar Registro', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo, 'accion'=>$accion,'proyecto'=>$proyecto),
		'confirm'=>'¿Está seguro que desea eliminar este registro?'
	)),
);
?>

<h1>Ver Registro #<?php echo $model->codigo; ?></h1>

<p><i>Detalles del registro.</i></p>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'imputacion_presupuestaria',
		array('label'=>'Material Servicio','value'=>MaterialesServicios::model()->findByPk($model->material_servicio)->descripcion),
		array('label'=>'Unidad Medida','value'=>UnidadMedida::model()->findByPk($model->unidad_medida)->unidad_medida),
		array('label'=>'Presentación','value'=>Presentacion::model()->findByPk($model->presentacion)->presentacion),
		'unidad_presentacion',
		'precio_unitario',
		'iva',
		'trim_i',
		'trim_ii',
		'trim_iii',
		'trim_iv',
		'sub_total',
		'total_iva',
		'total',
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('reporte/index',array('accion'=>$accion,'proyecto'=>$proyecto))); ?>