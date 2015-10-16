<?php
$this->breadcrumbs=array(
	'Proyecto'=>array('proyecto/view','id'=>$proyecto),
	'Acción'=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'UE Asociadas'=>array('index','accion'=>$accion,'proyecto'=>$proyecto),
	'Buscar',
);

$this->menu=array(
	array('label'=>'Lista de UEL asociadas', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('accion-ue-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Buscar UEL asociadas</h1>

<p>
Opcionalmente puede utilizar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al inicio de cada valor para especificar como se realizará la búsqueda.
</p>

<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accion-ue-grid',
	'dataProvider'=>$model->search($accion),
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'codigo_ue',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('accionUe/index',array('accion'=>$accion,'proyecto'=>$proyecto))); ?>