<?php
$this->breadcrumbs=array(
	'Proyecto'=>array('proyecto/view','id'=>$proyecto),
	'Acción'=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'UE Asociadas'=>array('index','accion'=>$accion,'proyecto'=>$proyecto),
	'Asignar',
);

$this->menu=array(
	array('label'=>'Lista de UEL asociadas', 'url'=>array('index','accion'=>$accion,'proyecto'=>$proyecto)),
);
?>

<h1>Asignar UEL</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('acciones/view',array('id'=>$accion,'proyecto'=>$proyecto))); ?>