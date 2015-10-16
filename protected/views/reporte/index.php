<?php
$this->breadcrumbs=array(
	'Proyecto'=>array('proyecto/view','id'=>Proyecto::model()->findByAttributes(array('codigo'=>$proyecto))->codigo),
	'Accion '.$accion=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'Reportes',
);

$this->menu=array(
	array('label'=>'Crear Registro', 'url'=>array('create')),
);
?>

<h1>Reportes</h1>

<?php if(Yii::app()->user->hasFlash('admin')): ?>

<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('admin'); ?>
</div>

<?php else: ?>

<p><i>Lista de reportes asociados a la acción.</i></p>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'viewData'=>array('accion'=>$accion,'proyecto'=>$proyecto)
)); ?>

<?php endif; ?>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('acciones/view',array('id'=>$accion,'proyecto'=>$proyecto))); ?>