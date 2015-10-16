<?php
$this->breadcrumbs=array(
	'IVA'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Lista de IVA', 'url'=>array('index')),
);
?>

<h1>Create Iva</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('iva/index')); ?>