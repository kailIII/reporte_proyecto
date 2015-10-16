<?php
$this->breadcrumbs=array(
	'Unidad Medidas'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Unidad Medida', 'url'=>array('index')),
	array('label'=>'Actualizar Unidad Medida', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Borrar UnidadMedida', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View UnidadMedida #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'unidad_medida',
		'id',
		array('label'=>'Tipo','value'=>TipoUnidadMedida::model()->findByPk($model->tipo)->tipo),
	),
)); ?>
<br/>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('unidadMedida/index')); ?>