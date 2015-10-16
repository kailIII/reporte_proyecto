<?php
$this->breadcrumbs=array(
	'Historico Reportes'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista Historico Reporte', 'url'=>array('index')),
	array('label'=>'Buscar Historico Reporte', 'url'=>array('admin')),
);
?>

<h1>Ver Histórico Reporte #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'codigo_reporte',
		array('label'=>'Usuario','value'=>Usuario::model()->findByPk($model->codigo_usuario)->usuario),
		array('label'=>'Operación','value'=>Operacion::model()->findByPk($model->operacion)->operacion),
		'fecha',
	),
)); ?>

</br>
<h2>Detalles del Reporte</h2>

<?php 
	//Reporte
	$reporte=Reporte::model()->findByPk($model->codigo_reporte);

	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$reporte,
		'attributes'=>array(
			'codigo',
			'imputacion_presupuestaria',
			array('label'=>'Material/Servicio','value'=>MaterialesServicios::model()->findByPk($reporte->material_servicio)->descripcion),
			array('label'=>'Unidad Medida','value'=>UnidadMedida::model()->findByPk($reporte->unidad_medida)->unidad_medida),
			array('label'=>'Presentación','value'=>Presentacion::model()->findByPk($reporte->presentacion)->presentacion),
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
	)); 
?>
