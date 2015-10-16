
<h1>Reporte General</h1>

<div class="form">

	<?php
		//Proyecto
		$this->renderPartial('_proyecto',array(
			'proyecto'=>$proyecto, //Instancia de proyecto
			'total'=>$totalProyecto['proyecto'] //Total del proyecto
		));
	?>

	<?php 
		//Relacion Unidad Ejecutora - Accion
		foreach ($aue[$accion] as $j => $k) 
		{
			//Unidad Ejecutora
			$ue=UnidadEjecutora::model()->findByPk($k->codigo_ue);
	?>
		<?php
			//Unidad Ejecutora
			$this->renderPartial('_ue',array(
				'ue'=>$ue, //Instancia de unidad ejecutora
			));
		?>

		<br><!-- Salto de linea -->
		<table class="collapsed medium"><!-- Accion -->
			<thead>
				<tr>
					<th style="width:85px">Código Acción</th>
					<th>Nombre de la acción</th>
					<th style="width:118px">Total</th>
				</tr>
			</thead>
			<tbody>

		<?php						
			//Accion
			$this->renderPartial('_accion', array(
				'accion'=>Acciones::model()->findByPk($accion), //instancia de accion
				'total'=>$totalProyectoAcciones[$proyecto->codigo]['acciones'][$accion] //Total de la accion
			));					
		?>

			</tbody>
		</table> <!-- Accion -->

		<br><!-- Salto de linea -->


		<div id="<?php echo $accion; ?>">
		
		<?php			
			//Registros			
			$this->renderPartial('_planificacion',array(
				'registros'=>$registros[$accion][$k->codigo], //Registros por accion - unidad ejecutora
				'codigo_accion'=>$accion
			),false,true);				
		?>			

		</div>
		
	<?php	 
		} //Fin Relacion Unidad Ejecutora - Accion
		
	?>
		
		


</div>

</br><!-- Espacio -->