<?php
$this->breadcrumbs=array(
	'Proyecto'=>array('proyecto/view','id'=>$proyecto),
	'Acción'=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'UE Asociadas',
);

$this->menu=array(
	array('label'=>'Asignar UEL', 'url'=>array('create','accion'=>$accion,'proyecto'=>$proyecto)),
	array('label'=>'Buscar UEL asociadas', 'url'=>array('admin','accion'=>$accion,'proyecto'=>$proyecto)),
);
?>

<h1>UEL asociadas</h1>

<p><i>Lista de Unidades Ejecutoras asociadas a la acción.</i></p>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'viewData'=>array('accion'=>$accion,'proyecto'=>$proyecto)
)); ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('acciones/view',array('id'=>$accion,'proyecto'=>$proyecto))); ?>