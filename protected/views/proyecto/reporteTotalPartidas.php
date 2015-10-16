<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Proyecto '.$proyecto->codigo=>array('proyecto/view','id'=>$proyecto->codigo),
		'Total partidas'
	);

?>

<h1>Total del proyecto, sus acciones y partidas</h1>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'proyecto-form',
		'enableAjaxValidation'=>false,
		'action'=>CController::createUrl('proyecto/imprimirTotalPartidas')
	)); ?>

	<p class="note">El total del proyecto, los totales de sus acciones correspondientes y las partidas en cada acción.</p>

	<div class="row">
		<h4><?php echo $ue->codigo_uel." - ".$ue->denominacion; ?></h4><!-- Nombre y codigo de la UE -->
	</div>

	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

	<?php if(empty($partidaAccion) || empty($partidaGeneral)): ?>

		<div class="row">
			No se encontraron resultados.
		</div>
		<?php $this->endWidget(); ?><!-- Termina el formulario -->
	<?php else: ?>

	<!-- Hidden input para enviar el codigo del proyecto -->
	<?php echo CHtml::hiddenField('proyecto',$proyecto->codigo); ?>

	<?php
		//Proyecto
		$this->renderPartial('_proyecto',array(
			'proyecto'=>$proyecto, //Instancia de proyecto
			'total'=>$totalesProyectosAcciones[$proyecto->codigo]['proyecto'] //Total del proyecto
		));
	?>
	<?php
		//Por cada accion
		foreach($acciones as $key => $accion)
		{
	?>
		<br>
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
					'accion'=>$accion, //instancia de accion
					'total'=>$totalesProyectosAcciones[$proyecto->codigo]['acciones'][$accion['codigo']] //Total de la accion
				));
					
			?>
				</tbody>
			</table> <!-- Accion -->
	 		<?php
	 			//Si la accion posee registros
	 			if($partidaAccion[$accion['codigo']] != NULL)
	 			{

	 		?>
	 		<table class="collapsed medium"><!--Tabla con datos por partida -->
			 	<thead>
			 		<tr>
			 			<th style="width:85px">Partida</th>
			 			<th style="width:25px">GE</th>
			 			<th style="width:25px">ES</th>
			 			<th style="width:25px">SE</th>
			 			<th>Descripción</th>
			 			<th style="width:118px">Total</th>
			 		</tr>
			 	</thead>
		 		<tbody>
	 		<?php
	 				//Contador partida
		 			$cPartida='000';

	 				//Por cada partida que exista		 				
	 				foreach($partidaAccion[$accion['codigo']] as $k =>$v)
		 			{
		 				//Partida
		 				$partida=$v['imputacion_presupuestaria'];

		 				if($k == 0) //Si es el comienzo del arreglo
		 				{
		 					if($partida[0].$partida[1].$partida[2] =='403')
		 					{
		 						$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403000000',
									'ge'=>'00',
									'es'=>'00',
									'se'=>'00',
									'total'=>$partidaGeneral[$accion['codigo']][$k]['total']+$iva[$accion['codigo']]['iva'],
									'marked'=>true
								));

								//IVA
								$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403180100',
									'ge'=>'18',
									'es'=>'01',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>false
								));

								$this->renderPartial('_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));
		 					}
		 					elseif($partida[0].$partida[1].$partida[2] >'403')
		 					{
		 						$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403000000',
									'ge'=>'00',
									'es'=>'00',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>true
								));

								//IVA
								$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403180100',
									'ge'=>'18',
									'es'=>'01',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>false
								));

								//Partida General
			 					$this->renderPartial('_partidaGeneral',array(
										'partida'=>$partida,
										'ge'=>'00',
										'es'=>'00',
										'se'=>'00',
										'total'=>$partidaGeneral[$accion['codigo']][$k]['total'],
										'marked'=>true
									));
			 					
								$this->renderPartial('_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));
		 					}
		 					else
		 					{
		 						//Partida General
			 					$this->renderPartial('_partidaGeneral',array(
										'partida'=>$partida,
										'ge'=>'00',
										'es'=>'00',
										'se'=>'00',
										'total'=>$partidaGeneral[$accion['codigo']][$k]['total'],
										'marked'=>true
									));

			 					$this->renderPartial('_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));
		 					}		 					

		 					//Guardar temporalmente la partida
		 					$cPartida=$partida[0].$partida[1].$partida[2];
		 				}
		 				else
		 				{
		 					if($partida[0].$partida[1].$partida[2] == '403' &&  $partida[0].$partida[1].$partida[2] > $cPartida) //Servicios No Personales
							{
								$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403000000',
									'ge'=>'00',
									'es'=>'00',
									'se'=>'00',
									'total'=>$partidaGeneral[$accion['codigo']][$k]['total']+$iva[$accion['codigo']]['iva'],
									'marked'=>true
								));

								$this->renderPartial('_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));

								//IVA
								$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403180100',
									'ge'=>'18',
									'es'=>'01',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>false
								));

								//Guardar temporalmente la partida
		 						$cPartida=$partida[0].$partida[1].$partida[2];
							}
							else
							{
								if($partida[0].$partida[1].$partida[2] == '404' &&  $cPartida == '402')
								{
									$this->renderPartial('_partidaGeneral',array(
										'partida'=>'403000000',
										'ge'=>'00',
										'es'=>'00',
										'se'=>'00',
										'total'=>$iva[$accion['codigo']]['iva'],
										'marked'=>true
									));

									//IVA
									$this->renderPartial('_partidaGeneral',array(
										'partida'=>'403180100',
										'ge'=>'18',
										'es'=>'01',
										'se'=>'00',
										'total'=>$iva[$accion['codigo']]['iva'],
										'marked'=>false
									));
								}

								//Si es el comienzo de la partida
								if($partida[0].$partida[1].$partida[2] != $cPartida)
								{
									$this->renderPartial('_partidaGeneral',array(
										'partida'=>$partida,
										'ge'=>'00',
										'es'=>'00',
										'se'=>'00',
										'total'=>$partidaGeneral[$accion['codigo']][$k]['total'],
										'marked'=>true
									));

									$this->renderPartial('_partida',array(
					 					'partida'=>$partida,
					 					'total'=>$v['total']
					 				));

					 				//Guardar temporalmente la partida
		 							$cPartida=$partida[0].$partida[1].$partida[2];
								}
								else
								{
									$this->renderPartial('_partida',array(
					 					'partida'=>$partida,
					 					'total'=>$v['total']
					 				));
								}
							}
			 				
		 				}

		 				if(end($partidaAccion[$accion['codigo']]) == $v && $partida[0].$partida[1].$partida[2] < '403')
		 				{
		 					$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403000000',
									'ge'=>'00',
									'es'=>'00',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>true
								));

								//IVA
								$this->renderPartial('_partidaGeneral',array(
									'partida'=>'403180100',
									'ge'=>'18',
									'es'=>'01',
									'se'=>'00',
									'total'=>$iva[$accion['codigo']]['iva'],
									'marked'=>false
								));
		 				}
		 				
		 				
		 			}// fin foreach por partida
		 	?>
		 		</tbody>
			</table>
			<?php		 			
	 			} // Fin if($partidaAccion[$accion['codigo']] != NULL)
	 			else
	 			{
	 		?>
	 				<div style="border:1px solid #DDDDDD; padding:5px 5px;text-align:center">Datos No Disponibles.</div>
	 		<?php
	 			}
		 	?>
			 <?php
			 	} //Fin foreach cada accion
			 ?>

			 </br><!-- Espacio -->

			 <div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->

			 </br><!-- Espacio -->

			 <div class="row buttons">
				<?php 
					$this->widget('zii.widgets.jui.CJuiButton', array(
					    'buttonType'=>'submit',
					    'name'=>'btnImprimir',
					    'value'=>'1',
					    'caption'=>'PDF',
					));
				?>
				<?php 
					$this->widget('zii.widgets.jui.CJuiButton', array(
					    'buttonType'=>'button',
					    'name'=>'btnExcel',
					    'value'=>'1',
					    'caption'=>'Hoja de cálculo',
					    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/reporteTotalPartidasExcel', array('proyecto'=>$proyecto->codigo)).'";}'),
					));
				?>
			</div>
	<?php $this->endWidget(); ?> <!-- Termina el formulario -->
</div>
<?php endif; ?>

</br><!-- Espacio -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>