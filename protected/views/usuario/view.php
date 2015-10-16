<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->codigo,
);

$this->menu=array(
	array('label'=>'Lista de Usuarios', 'url'=>array('index')),
	array('label'=>'Actualizar Usuario', 'url'=>array('update', 'id'=>$model->codigo)),
	array('label'=>'Eliminar Usuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Buscar Usuario', 'url'=>array('admin')),
);
?>

<h1>View Usuario #<?php echo $model->codigo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'usuario',
		array('label'=>'Nivel','value'=>Nivel::model()->findByPk($model->nivel)->nivel),
		array(
			'label'=>'Unidad Ejecutora',
			'value'=>$model->uel != NULL ? UnidadEjecutora::model()->findByPk($model->uel)->denominacion : NULL), //Si no es NULL
		'fecha_creacion',
		array('label'=>'Estatus','value'=>Estatus::model()->findByPk($model->estatus)->estatus)
	),
)); ?>

</br>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('usuario/index')); ?>