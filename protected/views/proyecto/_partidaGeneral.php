<?php
	
	//El codigo de la partida
	$codigoPartida=$partida[0].$partida[1].$partida[2];

	$descripcion=Subpartida::model()->findByAttributes(array(
		'partida'=>$codigoPartida,
		'ge'=>$ge,
		'es'=>$es,
		'se'=>$se));

	if($marked)
	{
?>
<tr style="background-color:#e3e3e3">
<?php
	}else{
?>
<tr>
<?php } ?>
	<td><?php echo $codigoPartida; ?></td> <!-- Partida -->
	<td><?php echo $ge; ?></td> <!-- GE -->
	<td><?php echo $es; ?></td> <!-- ES -->
	<td><?php echo $se; ?></td> <!-- SE -->
	<td><?php echo $descripcion['descripcion']; ?></td>
	<td style="text-align:right"><?php echo Yii::app()->format->number($total); ?></td>
</tr>