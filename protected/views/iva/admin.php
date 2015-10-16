<?php
$this->breadcrumbs=array(
	'IVA'=>array('index'),
	'Buscar',
);

$this->menu=array(
	array('label'=>'Lista de IVA', 'url'=>array('index')),
	array('label'=>'Crear IVA', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('iva-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Buscar IVA</h1>

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
	'id'=>'iva-grid',
	'dataProvider'=>$model->search(),
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'iva',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('iva/index')); ?>