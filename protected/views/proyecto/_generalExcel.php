<?php

	header('Content-type: application/excel; charset=utf-8');
	$filename = 'General.xls';
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