<?php
$this->breadcrumbs=array(
	'Presentación'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Lista de Presentación', 'url'=>array('index')),
	array('label'=>'Ver Presentación', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Update Presentacion <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('presentacion/index',array('id'=>$model->codigo))); ?>