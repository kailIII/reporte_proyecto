<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Proyecto '.$proyecto->codigo=>array('proyecto/view','id'=>$proyecto->codigo),
		'Reporte Total de Acciones'
	);
?>

<h1>Total del proyecto y sus acciones</h1>

<div class="form">
	<?php
		//Proyecto
		$this->renderPartial('_proyecto',array(
			'proyecto'=>$proyecto, //Instancia de proyecto
			'total'=>$totalesProyectosAcciones[$proyecto->codigo]['proyecto'] //Total del proyecto
		));
	?>
	<table class="collapsed medium">
		<thead>
			<tr>
				<th style="width:85px">Código Acción</th>
				<th>Nombre de la acción</th>
				<th style="width:118px">Total</th>
			</tr>
		</thead>
		<tbody>
			 <?php
			 	//Por cada accion
				foreach($acciones as $key => $value)
			 	{
			 		//Accion
			 		$this->renderPartial('_accion', array(
			 			'accion'=>$value, //instancia de accion
			 			'total'=>$totalesProyectosAcciones[$proyecto->codigo]['acciones'][$value['codigo']] //Total de la accion
			 		));
			 	} //Fin foreach cada accion
			 ?>
		</tbody>
	</table>
</div>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>