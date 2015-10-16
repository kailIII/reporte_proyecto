<div style="text-align:center"><h2>PROYECTO: <?php echo $proyecto->nombre; ?></h2></div><!-- NOmbre del proyecto -->
<?php
	//Buscar la unidad ejecutora
	$ue=UnidadEjecutora::model()->findByPk(Yii::app()->user->uel);
?>
<div class="row">
	<h3>UNIDAD EJECUTORA: <?php echo $ue->codigo_uel." - ".$ue->denominacion; ?></h3><!-- Nombre y codigo de la UE -->
</div>

<?php
	foreach($proveedor as $llave => $valor)
	{
?>
	<h4>ACCIÓN: <?php echo $nombreAccion[$llave]; ?></h4>

	<table style="border:1px solid black;border-collapse:collapse;">
		<thead style="border:1px solid black;border-collapse:collapse;">
			<tr style="border:1px solid black;border-collapse:collapse;background-color:#DDDDDD">
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Imputacion Presupuestaria</th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Producto o Servicio</th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Unidad de Medida</th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Presentación</th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Precio Unitario</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">IVA</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Trim I</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total Trim I</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Trim II</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total Trim II</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Trim III</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total Trim III</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Trim IV</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total Trim IV</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Sub Total</a></th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total IVA</th>
				<th style="border: 1px solid black;border-collapse:collapse;text-align:center">Total</a></th>
			</tr>
		</thead>
		<tbody style="border:1px solid black;border-collapse:collapse;">
			<?php
			
				foreach($proveedor[$llave]['dataProvider']->data as $j => $k)
				{
			?>
				<tr style="border:1px solid black;border-collapse:collapse;">
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->imputacion_presupuestaria; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo MaterialesServicios::model()->findByPk($k->material_servicio)->descripcion; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo UnidadMedida::model()->findByPk($k->unidad_medida)->unidad_medida; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo Presentacion::model()->findByPk($k->presentacion)->presentacion; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->precio_unitario; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->iva; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_i; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_i*$k->precio_unitario; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_ii; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_ii*$k->precio_unitario; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_iii; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_iii*$k->precio_unitario; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_iv; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo $k->trim_iv*$k->precio_unitario; ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo Yii::app()->format->number($k->sub_total); ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo Yii::app()->format->number($k->total_iva); ?></td>
					<td style="border: 1px solid black;border-collapse:collapse;text-align:center"><?php echo Yii::app()->format->number($k->total); ?></td>
				</tr>
			<?php
				} // foreach 
			?>
		</tbody>
	</table>
<?php
	} //foreach
?>