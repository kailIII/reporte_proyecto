<?php

	header('Content-type: application/excel; charset=utf-8');
	$filename = 'GeneralPartidasSubpartidas.xls';
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

<h1>General por Partida y Subpartidas</h1>

<div class="form">
	<p class="note">Total general (Proyectos y Acciones Centralizadas) con detalle de las partidas.</p>

<?php
	if($proyectos == null || $proyectos == ''): //Si no hay registros
?>
	<!-- Mensaje -->
	<div class="flash-notice">
		No hay registros.
	</div>

<?php else: ?>

	<div class="simple big">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalGeneral); ?>
	</div>

	<table class="collapsed medium">
		<thead>
			<tr>
				<th>Partida</th>
				<th>GE</th>
				<th>ES</th>
				<th>SE</th>
				<th>Denominación</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				//Para totalizar el IVA
				$ivaTotal = 0;

				foreach ($totalSubpartidas as $key => $value)
				{
					$imputacion=$value['imputacion_presupuestaria'];

					if(substr($imputacion, 3)=='000000')
					{
						//Sumar el iva al total general de la partida 403
						if($imputacion=='403000000'){$adicional=$iva['iva'];}else{$adicional=0;}

						$this->renderPartial('imprimir/_partidaGeneral',array(
							'partida'=>$imputacion,
							'ge'=>'00',
							'es'=>'00',
							'se'=>'00',
							'total'=>$totalPartida[$imputacion[0].$imputacion[1].$imputacion[2]]['total']+$adicional,
							'marked'=>true
						));
					}else
					{
						if($imputacion == '403180100') //Partida que contiene el IVA
						{
							$this->renderPartial('imprimir/_partida',array(
								'partida'=>$imputacion,
								'total'=>$value['total']+$iva['iva']
							));
						}
						else
						{
							$this->renderPartial('imprimir/_partida',array(
								'partida'=>$imputacion,
								'total'=>$value['total']
							));
						}
					}	
				}
			?>
		</tbody>
	</table>

</div><!--form-->

<?php endif; ?><!-- Termina la condicion -->