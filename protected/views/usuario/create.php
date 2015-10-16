<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Lista de Usuarios', 'url'=>array('index')),
	array('label'=>'Buscar Usuario', 'url'=>array('admin')),
);
?>

<h1>Create Usuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('usuario/index')); ?>