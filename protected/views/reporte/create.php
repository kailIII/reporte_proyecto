<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('proyecto/index'),
	'Proyecto '.$proyecto=>array('proyecto/view','id'=>$proyecto),
	'Accion '.$accion=>array('acciones/view','id'=>$accion,'proyecto'=>$proyecto),
	'Crear',
);

$this->menu=array(
	array('label'=>'Lista de Registros', 'url'=>array('index')),
	array('label'=>'Buscar Registros', 'url'=>array('admin')),
);
?>

<h1>Crear Registro</h1>

<?php if(Yii::app()->user->hasFlash('admin')): ?>

<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('admin'); ?>
</div>

<?php else: ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'accion'=>$accion,'value'=>$value,'proyecto'=>$proyecto)); ?>

<?php endif; ?>

</br>
<!-- Para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('acciones/view',array('id'=>$accion,'proyecto'=>$proyecto))); ?>