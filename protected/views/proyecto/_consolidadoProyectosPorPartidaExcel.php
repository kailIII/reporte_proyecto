<?php

	header('Content-type: application/excel; charset=utf-8');
	$filename = 'Total por Partidas.xls';
	header('Content-Disposition: attachment; filename='.$filename);

	$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
	<head>
		<meta http-equiv="Content-Type" content="application/excel; charset=utf-8" />
	    <!--[if gte mso 9]>
	    <xml encoding="utf-8" lang="es">
	    	<ss:Styles>
	    		<ss:NumberFormat>#,###.00</ss:NumberFormat>
	    	</ss:Styles>
	        <x:ExcelWorkbook>
	            <x:ExcelWorksheets>
	                <x:ExcelWorksheet>
	                    <x:Name>Sheet 1</x:Name>
	                    <x:WorksheetOptions>
	                        <x:Print>
	                            <x:ValidPrinterInfo/>
	                        </x:Print>
	                    </x:WorksheetOptions>
	                </x:ExcelWorksheet>
	            </x:ExcelWorksheets>
	        </x:ExcelWorkbook>
	    </xml>
	    <![endif]-->
	    <style type="text/css">
	    	<!--table
	    		{mso-number-format:\@;}
	    	th{
	    		background-color:#c3d9ff;
	    	}
	    	td{
	    		mso-number-format:\@;
	    	}
	    	-->
	    </style>
	</head>
	';

	echo $data;
?>

<h1>Total <?php echo $PRYACC; ?></h1>

	<p class="note"><?php echo $PRYACC; ?> consolidado por partida.</p>

	<div class="simple big right">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalProyectos); ?>
	</div>
	<?php
		//Por cada partida
		$cuatrocerodos = 0;
		$cuatrocerotres = 0;
		$cuatrocerocuatro = 0;
		$cuatrocerocinco = 0;
		$cuatroceroseis = 0;
		$cuatrocerosiete = 0;

		//Por cada proyecto
		foreach ($proyectos as $llave => $valor)
		{
			
	?>	
	<?php if(!empty($pP[$valor->codigo])): ?>
		
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
						$cuatrocerotres= $cuatrocerotres+$totalizar;
						
						$totalizar=0;
					}
					

					if($anterior!=$partida && $anterior!=null)
					{

						if($anterior=='403')
						{
							$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							$cuatrocerotres= $cuatrocerotres+$totalizar;						
						}
						
						//Restaurar el valor inicial
						$totalizar=0;
					}						

					if($partida == '404' && $anterior == '402')
					{
						$totalizar=$iva[$valor->codigo]['iva']; //Solo el IVA
						
						//Restaurar el valor inicial
						$totalizar=0;
					}
					
					//Sumar
					$totalizar=$totalizar+$value['total'];

					//Acumular los totales
					if($partida == '402' && $anterior != $partida)
					{
						$cuatrocerodos = $cuatrocerodos + $totalizar;
					}
					if ($partida == '404' && $anterior != $partida) 
					{
						$cuatrocerocuatro = $cuatrocerocuatro + $totalizar;
					}
					if($partida == '407' && $anterior != $partida)
					{				
						$cuatrocerosiete = $cuatrocerosiete + $totalizar;
					}


					if($last == $key) //Si es el final del arreglo
					{
						if($partida=='403')
						{
							$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							$cuatrocerotres=$cuatrocerotres+$totalizar;
						}

						//Restaurar el valor inicial
						$totalizar=0;
						
					}
					//Partida actual de referencia
					$anterior=$partida;
				}

			?>
		
	<?php else: ?>
		<div style="border:1px solid #DDDDDD; padding:5px 5px;text-align:center">Datos No Disponibles.</div>
	<?php endif; ?>
	
	<?php
		} //Fin foreach cada proyecto
	?>
	<table class="collapsed medium">
		<thead>
			<tr>
				<th style="width:85px">Partida</th>
				<th>Descripción</th>
				<th style="width:118px">Total</th>
			</tr>
		</thead>
		<tbody>
		<?php
			//402
			echo '<tr style="background-color:#e3e3e3">';
			echo '<td>402</td>'; //Partida
			echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'402'))->descripcion.'</td>'; //Descripcion patida
			echo '<td style="text-align:right">'.Yii::app()->format->number($cuatrocerodos).'</td>'; //Total
			echo '</tr>';
			//403
			echo '<tr style="background-color:#e3e3e3">';
			echo '<td>403</td>'; //Partida
			echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion patida
			echo '<td style="text-align:right">'.Yii::app()->format->number($cuatrocerotres).'</td>'; //Total
			echo '</tr>';
			//404
			echo '<tr style="background-color:#e3e3e3">';
			echo '<td>404</td>'; //Partida
			echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'404'))->descripcion.'</td>'; //Descripcion patida
			echo '<td style="text-align:right">'.Yii::app()->format->number($cuatrocerocuatro).'</td>'; //Total
			echo '</tr>';
			//407
			echo '<tr style="background-color:#e3e3e3">';
			echo '<td>407</td>'; //Partida
			echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'407'))->descripcion.'</td>'; //Descripcion patida
			echo '<td style="text-align:right">'.Yii::app()->format->number($cuatrocerosiete).'</td>'; //Total
			echo '</tr>';
		?>
		</tbody>
	</table>

</br><!-- Salto de línea -->