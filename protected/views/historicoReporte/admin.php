<?php
$this->breadcrumbs=array(
	'Historico Reportes'=>array('index'),
	'Buscar',
);

$this->menu=array(
	array('label'=>'Lista Historico Reporte', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('historico-reporte-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Buscar Histórico Reportes</h1>

<p>
Opcionalmente puede utilizar operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al inicio de cada valor para especificar como se realizará la búsqueda.
</p>

<p>
	<b>Operación:</b> 1 = CREADO, 2 = MODIFICADO, 3 = ELIMINADO.
</p>

<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'historico-reporte-grid',
	'dataProvider'=>$model->search(),
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'codigo_reporte',
		'codigo_usuario',
		'operacion',
		'fecha',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
