<?php

	header('Content-type: application/excel; charset=utf-8');
	$filename = 'General_Trimestral.xls';
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

<?php
	
	foreach ($proyectos as $key => $proyecto) 
	{
		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));
		
		//Montos trimestrales
		$trimestral=$this->devolverTrimestral($acciones);
		//Iva trimestral
		$iva=$this->devolverTrimestralIva($acciones);
?>
<div class="form">

	<table class="collapsed medium"><!-- Proyecto -->
		<thead>
			<tr>
				<th style="width:85px">Código SNE</th>
				<th>Nombre del proyecto</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $proyecto->codigo_sne; ?></td>
				<td><?php echo $proyecto->nombre; ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="collapsed medium"><!-- Acciones -->
		<thead>
			<tr>
				<th>Acciones Específicas</th>
				<th>Partida</th>
				<th>Denominación</th>
				<th>I</th>
				<th>II</th>
				<th>III</th>
				<th>IV</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				//Totalizadores generales
				$total_trim_i=0; 
				$total_trim_ii=0; 
				$total_trim_iii=0; 
				$total_trim_iv=0;
				$total_total=0;

				foreach ($trimestral as $key => $accion) 
				{
					//Longitud de la columna con el nombre de la accion
					$rowspan=count($accion)+1;

					//Totalizadores
					$trim_i=0; 
					$trim_ii=0; 
					$trim_iii=0; 
					$trim_iv=0;
					$total=0;

					foreach ($accion as $llave => $valor) 
					{
						//if(array_values($accion)[0] == $valor) PHP 5.4+
						if(array_shift(array_slice($accion, 0, 1)) == $valor)
						{
							//nombre de la accion
							echo "<tr><td rowspan='".$rowspan."'>".$valor['accion']."</td></tr>";
						}

						if($valor['partida']=='403')
						{
							$valor['trim_i']=$valor['trim_i']+$iva[$key]['iva_trim_i'];
							$valor['trim_ii']=$valor['trim_ii']+$iva[$key]['iva_trim_ii'];
							$valor['trim_iii']=$valor['trim_iii']+$iva[$key]['iva_trim_iii'];
							$valor['trim_iv']=$valor['trim_iv']+$iva[$key]['iva_trim_iv'];
							$valor['total']=$valor['total']+$iva[$key]['iva_total'];
						}
						
						//Partida, denominacion, I, II, III, IV, Total
						$this->renderPartial('_trimestral',array('value'=>$valor));
						//Sumar para totalizar la accion
						$trim_i=$trim_i+$valor['trim_i'];
						$trim_ii=$trim_ii+$valor['trim_ii'];
						$trim_iii=$trim_iii+$valor['trim_iii'];
						$trim_iv=$trim_iv+$valor['trim_iv'];
						$total=$total+$valor['total'];
					}
			?>
					<!-- Totalizar la accion -->
					<tr style="background-color:#e3e3e3">
						<td colspan='3' style="text-align:center;font-weight:bold">Total Acción:</td>
						<td style="font-weight:bold"><?php echo $trim_i; ?></td>
						<td style="font-weight:bold"><?php echo $trim_ii; ?></td>
						<td style="font-weight:bold"><?php echo $trim_iii; ?></td>
						<td style="font-weight:bold"><?php echo $trim_iv; ?></td>
						<td style="font-weight:bold"><?php echo $total; ?></td>
					</tr>
			<?php
					//Sumar para totalizar el proyecto
					$total_trim_i=$total_trim_i+$trim_i;
					$total_trim_ii=$total_trim_ii+$trim_ii;
					$total_trim_iii=$total_trim_iii+$trim_iii;
					$total_trim_iv=$total_trim_iv+$trim_iv;
					$total_total=$total_total+$total;
				}
			?>
			<!-- Totalizar el proyecto -->
			<tr style="background-color:#c3d9ff">
				<td colspan='3' style="text-align:center;font-weight:bold">Total Proyecto:</td>
				<td style="font-weight:bold"><?php echo $total_trim_i; ?></td>
				<td style="font-weight:bold"><?php echo $total_trim_ii; ?></td>
				<td style="font-weight:bold"><?php echo $total_trim_iii; ?></td>
				<td style="font-weight:bold"><?php echo $total_trim_iv; ?></td>
				<td style="font-weight:bold"><?php echo $total_total; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php
	} //Foreach
?>
