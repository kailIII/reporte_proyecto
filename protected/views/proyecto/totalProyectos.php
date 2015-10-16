<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Total proyectos'
	);
?>

<h1>Total de los proyectos</h1>

<div class="form">
	<div class="simple big right">
		Total:<?php echo "Bs. ".number_format($totalProyectos,2,',','.'); ?>
	</div>
	<?php
		//Por cada proyecto
		foreach ($proyectos as $llave => $valor)
		{
			//Proyecto
			$this->renderPartial('_proyecto',array(
				'proyecto'=>$valor, //Instancia de proyecto
				'total'=>$totalesProyectosAcciones[$valor['codigo']]['proyecto'] //Total del proyecto
			));
			//Obtener las acciones del proyecto
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$valor['codigo']));
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
		 			'total'=>$totalesProyectosAcciones[$valor['codigo']]['acciones'][$value['codigo']] //Total de la accion
		 		));
		 	} //Fin foreach cada accion
		?>
		</tbody>
	</table>
	<div class="barra"></div><!--Separador-->
	<?php
		} //Fin foreach cada proyecto
	?>
</div>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/index')); ?>