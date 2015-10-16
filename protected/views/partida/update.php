<?php
$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista de Partidas', 'url'=>array('index')),
	array('label'=>'Ver Partida', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Actualizar Partida <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('partida/view',array('id'=>$model->codigo))); ?>