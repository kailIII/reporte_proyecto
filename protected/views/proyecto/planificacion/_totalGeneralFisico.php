<table class="inside">
	<thead>
		<tr class="centered">
			<th></th>
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

			$MaterialServicio=MaterialesServicios::model()->findByPk($v['material_servicio']);
	?>
		<tr class="centered">
			<td><?php echo 	$v['trim_i']+$v['trim_ii']+$v['trim_iii']+$v['trim_iv']; ?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
</table>