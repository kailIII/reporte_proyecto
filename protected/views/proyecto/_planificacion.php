<table class="collapsed medium">
	<thead>
		<tr class="centered">
			<th rowspan="1" colspan="2">IMPUTACIÓN PRESUPUESTARIA</th>
			<th rowspan="1" colspan="3">BASE DE CÁLCULO FÓRMULA</th>
			<th rowspan="1" colspan="4">TRIMESTRALIZACIÓN FÍSICA</th>
			<th rowspan="2">TOTAL GENERAL FÍSICO</th>
			<th rowspan="1" colspan="4">TRIMESTRALIZACIÓN DEL GASTO (FINANCIERO)</th>
			<th rowspan="2">TOTAL GENERAL FINANCIERO</th>
			<th rowspan="1" colspan="2">IVA</th>
			<th rowspan="1" colspan="4">IVA TRIMESTRAL</th>
		</tr>
		<tr class="centered">
			<th>CÓDIGO</th>
			<th>DENOMINACIÓN</th>
			<th>PRODUCTO O SERVICIO</th>
			<th>UNIDAD DE MEDIDA</th>
			<th>PRECIO UNITARIO</th>
			<th>TRIM I</th>
			<th>TRIM II</th>
			<th>TRIM III</th>
			<th>TRIM IV</th>
			<th>TRIM I</th>
			<th>TRIM II</th>
			<th>TRIM III</th>
			<th>TRIM IV</th>
			<th>%</th>
			<th>Bs.</th>
			<th>TRIM I</th>
			<th>TRIM II</th>
			<th>TRIM III</th>
			<th>TRIM IV</th>
		</tr>
	</thead>
	<tbody>			
		<?php
			foreach($registros as $r => $v) // Por cada registro
			{
				//Partida
				$partida=$v['imputacion_presupuestaria'][0].$v['imputacion_presupuestaria'][1].$v['imputacion_presupuestaria'][2];
				//Subpartidas
				$ge=$v['imputacion_presupuestaria'][3].$v['imputacion_presupuestaria'][4];
				$es=$v['imputacion_presupuestaria'][5].$v['imputacion_presupuestaria'][6];
				$se=$v['imputacion_presupuestaria'][7].$v['imputacion_presupuestaria'][8];
		?>
			<tr class="centered">
				<!-- IMPUTACIÓN PRESUPUESTARIA -->
				<td><?php echo $v['imputacion_presupuestaria']; ?></td>
				<td><?php echo Subpartida::model()->findByAttributes(array('partida'=>$partida, 'ge'=>$ge, 'es'=>$es, 'se'=>$se))->descripcion; ?>					
				<!-- BASE DE CÁLCULO FÓRMULA -->
				<?php
					$MaterialServicio=MaterialesServicios::model()->findByPk($v['material_servicio']);
				?>
				<td><?php echo $MaterialServicio->descripcion; ?></td>
				<td><?php echo UnidadMedida::model()->findByPk($MaterialServicio->unidad_medida)->unidad_medida; ?></td>
				<td><?php echo Yii::app()->format->number($v['precio_unitario']); ?></td>

				<!-- TRIMESTRALIZACIÓN FÍSICA -->
				<td><?php echo $v['trim_i']; ?></td>
				<td><?php echo $v['trim_ii']; ?></td>
				<td><?php echo $v['trim_iii']; ?></td>
				<td><?php echo $v['trim_iv']; ?></td>

				<!--TOTAL GENERAL FÍSICO-->			
				<td><?php echo 	$v['trim_i']+$v['trim_ii']+$v['trim_iii']+$v['trim_iv']; ?></td>

				<!-- TRIMESTRALIZACIÓN DEL GASTO (FINANCIERO) -->
				<td><?php echo Yii::app()->format->number($v['trim_i']*$v['precio_unitario']); ?></td>
				<td><?php echo Yii::app()->format->number($v['trim_ii']*$v['precio_unitario']); ?></td>
				<td><?php echo Yii::app()->format->number($v['trim_iii']*$v['precio_unitario']); ?></td>
				<td><?php echo Yii::app()->format->number($v['trim_iv']*$v['precio_unitario']); ?></td>

				<!-- TOTAL GENERAL FINANCIERO -->			
				<td><?php echo Yii::app()->format->number($v['sub_total']); ?></td>

				<!-- IVA-->
				<td><?php echo $v['iva']; ?></td>
				<td><?php echo $v['total_iva']; ?></td>

				<!-- IVA TRIMESTRAL -->
				<td><?php echo Yii::app()->format->number(($v['trim_i']*$v['precio_unitario'])/100*$v['iva']); ?></td>
				<td><?php echo Yii::app()->format->number(($v['trim_ii']*$v['precio_unitario'])/100*$v['iva']); ?></td>
				<td><?php echo Yii::app()->format->number(($v['trim_iii']*$v['precio_unitario'])/100*$v['iva']); ?></td>
				<td><?php echo Yii::app()->format->number(($v['trim_iv']*$v['precio_unitario'])/100*$v['iva']); ?></td>
			</tr>
		<?php
			} //Fin foreach
		?>
	</tbody>
</table>