<?php
	
	//El codigo de la partida
	$codigoPartida=$partida[0].$partida[1].$partida[2];
	//Arreglo con las subpartidas
	$subpartida=str_split(substr($partida, 3),2);

	$descripcion=Subpartida::model()->findByAttributes(array(
		'partida'=>$codigoPartida,
		'ge'=>$subpartida[0],
		'es'=>$subpartida[1],
		'se'=>$subpartida[2]));
	
?>
<tr>
	<td style="width:25px"><?php echo $codigoPartida; ?></td> <!-- Partida -->
	<td style="width:25px"><?php echo $subpartida[0]; ?></td> <!-- GE -->
	<td style="width:25px"><?php echo $subpartida[1]; ?></td> <!-- ES -->
	<td style="width:25px"><?php echo $subpartida[2]; ?></td> <!-- SE -->
	<td><?php echo $descripcion['descripcion']; ?></td>
	<td style="text-align:right"><?php echo Yii::app()->format->number($total); ?></td>
</tr>