<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Lista de Usuarios', 'url'=>array('index')),
	array('label'=>'Ver Usuario', 'url'=>array('view', 'id'=>$model->codigo)),
	array('label'=>'Buscar Usuario', 'url'=>array('admin')),
);
?>

<h1>Update Usuario <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('usuario/view',array('id'=>$model->codigo))); ?>