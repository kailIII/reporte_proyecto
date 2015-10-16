<?php
$this->breadcrumbs=array(
	'Unidad Medidas'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Ver Unidad Medida', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Actualizar Unidad Medida <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<br/>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('unidadMedida/view',array('id'=>$model->codigo))); ?>