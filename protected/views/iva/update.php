<?php
$this->breadcrumbs=array(
	'Ivas'=>array('index'),
	$model->codigo=>array('view','id'=>$model->codigo),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista IVA', 'url'=>array('index')),
	array('label'=>'Ver IVA', 'url'=>array('view', 'id'=>$model->codigo)),
);
?>

<h1>Update Iva <?php echo $model->codigo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('iva/view',array('id'=>$model->codigo))); ?>