<?php
$this->breadcrumbs=array(
	'Acciones'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Buscar Acción', 'url'=>array('admin')),
);
?>

<h1>Create Acciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto))); ?>