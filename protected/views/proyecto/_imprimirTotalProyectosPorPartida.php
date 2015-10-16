<h1>Total <?php echo $PRYACC; ?></h1>

<p class="note"><?php echo $PRYACC; ?> y sus partidas principales.</p>

<div class="simple big right">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalProyectos); ?>
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

	?>
	<?php if(!empty($pP[$valor->codigo])): ?>

		<table class="collapsed medium" style="vertical-align:center">
			<thead>
				<tr>
					<th style="width:85px">Partida</th>
					<th>Descripción</th>
					<th style="width:118px">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//Inicializar variables para sumar y contar
					$anterior=null;
					$totalizar=0;

					//Obtener el final del arreglo para referencia
					end($pP[$valor->codigo]); //Colocar el puntero al final del arreglo
					$last=key($pP[$valor->codigo]); //Obtener la ultima llave

					foreach ($pP[$valor->codigo] as $key => $value)
					{
						//Extraer la partida
						$partida=$value['imputacion_presupuestaria'];
						$partida=$partida[0].$partida[1].$partida[2];
						
						if($partida > '403' && $anterior==null)
						{
							$totalizar=$totalizar+$iva[$valor->codigo]['iva'];

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>403</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							$totalizar=0;
						}
						

						if($anterior!=$partida && $anterior!=null)
						{

							if($anterior=='403')
							{
								$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							}

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>'.$anterior.'</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>$anterior))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							//Restaurar el valor inicial
							$totalizar=0;
						}

						if($partida == '404' && $anterior == '402')
						{
							$totalizar=$iva[$valor->codigo]['iva']; //Solo el IVA

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>403</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';
						}
						
						//Sumar
						$totalizar=$totalizar+$value['total'];


						if($last == $key) //Si es el final del arreglo
						{
							if($partida=='403')
							{
								$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							}

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>'.$partida.'</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>$partida))->descripcion.'</td>'; //Descripcion patida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							if($partida<'403')
							{
								echo '<tr style="background-color:#e3e3e3">';
								echo '<td>403</td>'; //Partida
								echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion patida
								echo '<td style="text-align:right">'.Yii::app()->format->number($iva[$valor->codigo]['iva']).'</td>'; //IVA
								echo '</tr>';
							}

							//Restaurar el valor inicial
							$totalizar=0;
							
						}
						//Partida actual de referencia
						$anterior=$partida;
					}
				?>
			</tbody>
		</table>
	<?php else: ?>
		<div style="border:1px solid #DDDDDD; padding:5px 5px;text-align:center">Datos No Disponibles.</div>
	<?php endif; ?>	
	<pagebreak type="NEXT-ODD" /><!-- Salto de pagina -->
	<?php

		} //Fin foreach cada proyecto
	?>
</div>