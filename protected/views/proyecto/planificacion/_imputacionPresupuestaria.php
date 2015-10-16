<table class="inside">
	<thead>
		<tr class="centered">
			<th>CÓDIGO</th>
			<th>DENOMINACIÓN</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($registros as $r => $v)
			{
				//Partida
				$partida=$v['imputacion_presupuestaria'][0].$v['imputacion_presupuestaria'][1].$v['imputacion_presupuestaria'][2];
				//Subpartidas
				$ge=$v['imputacion_presupuestaria'][3].$v['imputacion_presupuestaria'][4];
				$es=$v['imputacion_presupuestaria'][5].$v['imputacion_presupuestaria'][6];
				$se=$v['imputacion_presupuestaria'][7].$v['imputacion_presupuestaria'][8];
		?>
		<tr class="centered">
			<td><?php echo $v['imputacion_presupuestaria']; ?></td>
			<td><?php echo Subpartida::model()->findByAttributes(array('partida'=>$partida, 'ge'=>$ge, 'es'=>$es, 'se'=>$se))->descripcion; ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>