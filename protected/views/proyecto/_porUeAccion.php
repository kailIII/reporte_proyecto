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
			'total'=>$totalProyectoAcciones['acciones'][$accion['codigo']] //Total de la accion
		));
		
?>
	</tbody>
</table>
	<?php
		//Si la accion posee registros
		if($partidaAccion[$accion['codigo']] != NULL)
		{
	?>
<table class="collapsed medium"><!--Tabla con datos por partida -->
 	<thead>
 		<tr>
 			<th style="width:85px">Partida</th>
 			<th>GE</th>
 			<th>ES</th>
 			<th>SE</th>
 			<th>Descripción</th>
 			<th style="width:118px">Total</th>
 		</tr>
 	</thead>
	<tbody>
		<?php
			
			//Contador partida
	 			$cPartida=null;
	 			
 				//Por cada partida que exista		 				
 				foreach($partidaAccion[$accion['codigo']] as $k =>$v)
	 			{
	 				//Partida
	 				$partida=$v['imputacion_presupuestaria'];
	 				
	 				if($k == 0) //Si es el comienzo del arreglo
	 				{
	 					if($partida[0].$partida[1].$partida[2] >= '403')
	 					{
	 						$this->renderPartial('imprimir/_partidaGeneral',array(
								'partida'=>'403000000',
								'ge'=>'00',
								'es'=>'00',
								'se'=>'00',
								'total'=>$iva[$accion['codigo']]['iva'],
								'marked'=>true
							));

							//IVA
							$this->renderPartial('imprimir/_partidaGeneral',array(
								'partida'=>'403180100',
								'ge'=>'18',
								'es'=>'01',
								'se'=>'00',
								'total'=>$iva[$accion['codigo']]['iva'],
								'marked'=>false
							));
	 					}
	 				
	 				
	 					//Partida General
	 					$this->renderPartial('imprimir/_partidaGeneral',array(
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
	 					if($partida[0].$partida[1].$partida[2] == '403' &&  $partida[0].$partida[1].$partida[2] > $cPartida) //Servicios No Personales
						{
							$this->renderPartial('imprimir/_partidaGeneral',array(
								'partida'=>'403000000',
								'ge'=>'00',
								'es'=>'00',
								'se'=>'00',
								'total'=>$partidaGeneral[$accion['codigo']][$k]['total']+$iva[$accion['codigo']]['iva'],
								'marked'=>true
							));

							$this->renderPartial('imprimir/_partida',array(
			 					'partida'=>$partida,
			 					'total'=>$v['total']
			 				));

							//IVA
							$this->renderPartial('imprimir/_partidaGeneral',array(
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
								$this->renderPartial('imprimir/_partidaGeneral',array(
									'partida'=>$partida,
									'ge'=>'00',
									'es'=>'00',
									'se'=>'00',
									'total'=>$partidaGeneral[$accion['codigo']][$k]['total'],
									'marked'=>true
								));

								$this->renderPartial('imprimir/_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));

				 				//Guardar temporalmente la partida
	 							$cPartida=$partida[0].$partida[1].$partida[2];
							}
							else
							{
								$this->renderPartial('imprimir/_partida',array(
				 					'partida'=>$partida,
				 					'total'=>$v['total']
				 				));
							}
						}
		 				
	 				}
					
	 				if(end($partidaAccion[$accion['codigo']]) == $v && $partida[0].$partida[1].$partida[2] < '403')
	 				{
	 					$this->renderPartial('imprimir/_partidaGeneral',array(
								'partida'=>'403000000',
								'ge'=>'00',
								'es'=>'00',
								'se'=>'00',
								'total'=>$iva[$accion['codigo']]['iva'],
								'marked'=>true
							));

							//IVA
							$this->renderPartial('imprimir/_partidaGeneral',array(
								'partida'=>'403180100',
								'ge'=>'18',
								'es'=>'01',
								'se'=>'00',
								'total'=>$iva[$accion['codigo']]['iva'],
								'marked'=>false
							));
	 				}
	 			} // Fin foreach
		?>
	 </tbody>
</table>

</br><!-- Salto de linea -->

<div class="row buttons">
	<?php 
		$this->widget('zii.widgets.jui.CJuiButton', array(
		    'buttonType'=>'submit',
		    'name'=>'btnSubmit',
		    'value'=>'1',
		    'caption'=>'PDF',
		));
	?>
</div>

<?php		 			
	} // Fin if($partidaAccion[$value['codigo']] != NULL)
	else
	{
?>
		<div style="border:1px solid #DDDDDD; padding:5px 5px;text-align:center">Datos No Disponibles.</div>
<?php
	}
?>		