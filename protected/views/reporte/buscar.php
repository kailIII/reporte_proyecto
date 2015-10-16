<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('proyecto/index'),
	'Proyecto '.$proyecto=>array('proyecto/view','id'=>Proyecto::model()->findByAttributes(array('codigo'=>$proyecto))->codigo),
	'Accion '.$accion=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'Buscar Registros',
);

$this->menu=array(
	array('label'=>'List Reporte', 'url'=>array('index')),
	array('label'=>'Create Reporte', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('reporte-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Buscar Registros</h1>

<p>
Opcionalmente puede utilizar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al inicio de cada valor para especificar como se realizará la búsqueda.
</p>
<?php /*
<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'reporte-grid',
	'dataProvider'=>$model->buscar(Yii::app()->user->uel),
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'imputacion_presupuestaria',
		array(
			'name'=>'material_servicio',
			'value'=>function($data){
				return MaterialesServicios::model()->findByPk($data->material_servicio)->descripcion;
			}
		),
		'precio_unitario',
		/*
		'unidad_medida',
		'presentacion',
		'unidad_presentacion',
		'iva',
		'trim_i',
		'trim_ii',
		'trim_iii',
		'trim_iv',
		'sub_total',
		'total_iva',
		'total',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'url'=>function($data,$row){
						$accion=AccionUe::model()->findByPk($data->accion_ue)->codigo_accion;
						$proyecto=Acciones::model()->findByPk($accion)->codigo_proyecto;
						return CController::createUrl('/reporte/view', array('id'=>$data->codigo,'accion'=>$accion,'proyecto'=>$proyecto));
					},
				),
			),
		),
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('acciones/view',array('id'=>$accion,'proyecto'=>$proyecto))); ?>