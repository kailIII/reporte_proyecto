<h2>Opciones</h2>

<p><i>Agregar, Editar o Eliminar:</i></p>
<div>
	<ul>
		<li><?php echo CHtml::link('IVA', CController::createUrl('iva/index')); ?></li>
		<li><?php echo CHtml::link('Materiales y servicios', CController::createUrl('materialesServicios/index')); ?></li>
		<li><?php echo CHtml::link('Partidas', CController::createUrl('partida/index')); ?></li>
		<li><?php echo CHtml::link('Presentación', CController::createUrl('presentacion/index')); ?></li>
		<li><?php echo CHtml::link('Subpartidas', CController::createUrl('subpartida/index')); ?></li>		
		<li><?php echo CHtml::link('Unidad ejecutora', CController::createUrl('unidadEjecutora/index')); ?></li>
		<li><?php echo CHtml::link('Unidad de medida', CController::createUrl('unidadMedida/index')); ?></li>
		<li><?php echo CHtml::link('Usuarios', CController::createUrl('usuario/index')); ?></li>
		
	</ul>
</div>

<h2>Módulos de carga</h2>

<p><i>Opciones de carga masiva de datos:</i></p>
<div>
	<ul>
		<li><?php echo CHtml::link('Proyectos y acciones', CController::createUrl('site/cargaProyectoAccion/')); ?></li>
		<li><?php echo CHtml::link('Materiales y servicios', CController::createUrl('materialesServicios/importar/')); ?></li>
	</ul>
</div>

<h2>Base de datos</h2>

<p><i>Respaldos y otras opciones:</i></p>
<div>
	<ul>
		<li><?php echo CHtml::link('Respaldos', CController::createUrl('backup/default/index')); ?></li>
		<li><?php echo CHtml::link('Registrar', CController::createUrl('site/registrarBd')); ?></li>
	</ul>
</div>