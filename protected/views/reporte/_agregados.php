<?php
	//accion_ue
	$aue=AccionUe::model()->find(array(
		'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
		'params'=>array(':codigo_accion'=>$accion,':codigo_ue'=>Yii::app()->user->uel)
	));
	//reporte
	$reportes=Reporte::model()->findAll(array(
		'condition'=>'estatus=1 AND accion_ue='.$aue->codigo,
		'order'=>'codigo DESC',
		'limit'=>5,
		)
	);
?>
<?php
	if(!empty($reportes)) //Si existen registros
	{
?>
<div>
<table class="collapsed">
	<thead>
		<tr>
			<th><div class="t1">Imp. pres.</div></th>
			<th><div class="t2">Material/Servicio</div></th>
			<th><div class="t3">Unidad medida</div></th>
			<th><div class="t4">Presentación</div></th>
			<th><div class="t5">Unidad x p.</div></th>
			<th><div class="t6">Precio unitario</div></th>
			<th><div class="t7">IVA</div></th>
			<th><div class="t8">Trim I</div></th>
			<th><div class="t9">Trim II</div></th>
			<th><div class="t10">Trim III</div></th>
			<th><div class="t11">Trim IV</div></th>
			<th><div class="t12">Sub-total</div></th>
			<th><div class="t13">Total IVA</div></th>
			<th><div class="t14">Total</div></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($reportes as $key => $value)
		{
	?>
		<tr>
			<td><div class="t1"><?php echo $value['imputacion_presupuestaria']; ?></div></td>
			<td><div class="t2"><?php echo MaterialesServicios::model()->findbyPk($value['material_servicio'])->descripcion; ?></div></td>
			<td><div class="t3"><?php echo UnidadMedida::model()->findbyPk($value['unidad_medida'])->id; ?></div></td>
			<td><div class="t4"><?php echo Presentacion::model()->findbyPk($value['presentacion'])->presentacion; ?></div></td>
			<td><div class="t5"><?php echo $value['unidad_presentacion']; ?></div></td>
			<td><div class="t6"><?php echo $value['precio_unitario']; ?></div></td>
			<td><div class="t7"><?php echo $value['iva']; ?></div></td>
			<td><div class="t8"><?php echo $value['trim_i']; ?></div></td>
			<td><div class="t9"><?php echo $value['trim_ii']; ?></div></td>
			<td><div class="t10"><?php echo $value['trim_iii']; ?></div></td>
			<td><div class="t11"><?php echo $value['trim_iv']; ?></div></td>
			<td><div class="t12"><?php echo $value['sub_total']; ?></div></td>
			<td><div class="t13"><?php echo $value['total_iva']; ?></div></td>
			<td><div class="t14"><?php echo $value['total']; ?></div></td>
		</tr>
	<?php
		}
	?>
	</tbody>
</table>
</div>
<?php 
	} //Fin if(!empty($reportes))
?>