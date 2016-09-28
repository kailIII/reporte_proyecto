<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Total proyectos'
	);
?>

<h2>Seleccione la categoría que desee mostar:</h2>

<div>
	<h3>Detalle</h3>
	<ul>
		<li><?php echo CHtml::link('Todos', CController::createUrl('proyecto/totalProyectosPorPartida', array('tipo'=>1))); ?></li>
		<li><?php echo CHtml::link('Proyectos', CController::createUrl('proyecto/totalProyectosPorPartida', array('tipo'=>2))); ?></li>
		<li><?php echo CHtml::link('Acciones Centralizadas', CController::createUrl('proyecto/totalProyectosPorPartida', array('tipo'=>3))); ?></li>		
	</ul>

	<h3>Consolidado</h3>
	<ul>
		<li><?php echo CHtml::link('Todos', CController::createUrl('proyecto/consolidadoProyectosPorPartida', array('tipo'=>1))); ?></li>
		<li><?php echo CHtml::link('Proyectos', CController::createUrl('proyecto/consolidadoProyectosPorPartida', array('tipo'=>2))); ?></li>
		<li><?php echo CHtml::link('Acciones Centralizadas', CController::createUrl('proyecto/consolidadoProyectosPorPartida', array('tipo'=>3))); ?></li>
	</ul>

</div>

</br><!-- Salto de línea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/index')); ?>