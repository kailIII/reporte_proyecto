<?php
$this->breadcrumbs=array(
	'Acciones'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Ver Acción', 'url'=>array('view', 'id'=>$model->codigo)),
	array('label'=>'Buscar Acción', 'url'=>array('admin')),
);
?>

<h1>Actualizar Acción #<?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>Proyecto::model()->findByPk($proyecto)->codigo))); ?>