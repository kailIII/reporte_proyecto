<table class="collapsed big">
	<thead>
		<tr>
			<th style="width:85px">Código SNE</th>
			<th>Nombre del proyecto</th>
			<th style="width:118px">Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $proyecto->codigo_sne; ?></td>
			<td><?php echo $proyecto->nombre; ?></td>
			<td style="text-align:right"><?php echo "Bs. ".Yii::app()->format->number($total); ?></td>
		</tr>
	</tbody>
</table>