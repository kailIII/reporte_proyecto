<?php
$this->breadcrumbs=array(
	'Acciones'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Lista de Acciones', 'url'=>array('index')),
	array('label'=>'Crear Acciones', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('acciones-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Buscar Acciones</h1>

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
	'id'=>'acciones-grid',
	'dataProvider'=>$model->search(),
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'accion',
		'codigo_proyecto',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{update}{delete}',
			'buttons'=>array(
				'view'=>array(
					'url'=>function($data){
						return CController::createUrl('/acciones/view',array('id'=>$data->codigo,'proyecto'=>$data->codigo_proyecto));
					},
				),
				'update'=>array(
					'url'=>function($data){
						return CController::createUrl('/acciones/update',array('id'=>$data->codigo,'proyecto'=>$data->codigo_proyecto));
					},
				),
				'delete'=>array(
					'url'=>function($data){
						return CController::createUrl('/acciones/delete',array('id'=>$data->codigo,'proyecto'=>$data->codigo_proyecto));
					},
				),
			),
		),
	),
)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>Proyecto::model()->findByPk($proyecto)->codigo))); ?>