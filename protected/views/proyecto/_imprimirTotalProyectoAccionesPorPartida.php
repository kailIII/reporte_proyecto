
<h1>Total de los proyectos</h1>

<div class="form">

	<p class="note">Total de los proyectos, acciones y partidas principales.</p>

	<div class="simple big right">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalProyectos); ?>
	</div>
	<?php
	
		//Por cada proyecto
		foreach ($proyectos as $llave => $proyecto)
		{
			
			//Proyecto
			$this->renderPartial('_proyecto',array(
				'proyecto'=>$proyecto, //Instancia de proyecto
				'total'=>$totalesProyectosAcciones[$proyecto['codigo']]['proyecto'] //Total del proyecto
			));
		
	?>
		<?php
			//Las acciones
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));

			//Por cada accion
			foreach($acciones as $key => $accion)
			{ 
				
		?>
		<!-- Accion -->
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

			//Accion
			$this->renderPartial('_accion', array(
				'accion'=>$accion, //instancia de accion
				'total'=>$totalAccion[$proyecto->codigo]['acciones'][$accion['codigo']] //Total de la accion
			));
			
		?>
			</tbody>
		</table>
		<?php
		//print_r($pP[$accion->codigo]);
		
			//Partidas
			$this->renderPartial('_accionPartidaGeneral', array(
				'pP'=>$pP,
				'valor'=>$accion,
				'iva'=>$iva,
			));
		
		?>
		<?php
			} //Fin foreach accion
		?>
		<div class="barra"></div><!--Separador-->
	<?php
		}//Fin foreach proyecto 
	?>
</div>
