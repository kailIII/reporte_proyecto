<?php
$this->breadcrumbs=array(
	'Subpartidas'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista de Subpartida', 'url'=>array('index')),
	array('label'=>'Ver Subpartida', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Actualizar Subpartida <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('subpartida/view',array('id'=>$model->codigo))); ?>