<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo,'accion'=>$accion,'proyecto'=>$proyecto)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('accion_ue')); ?>:</b>
	<?php echo CHtml::encode($data->accion_ue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imputacion_presupuestaria')); ?>:</b>
	<?php echo CHtml::encode($data->imputacion_presupuestaria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_servicio')); ?>:</b>
	<?php echo CHtml::encode(MaterialesServicios::model()->findByPk($data->material_servicio)->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad_medida')); ?>:</b>
	<?php echo CHtml::encode(UnidadMedida::model()->findByPk($data->unidad_medida)->unidad_medida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('presentacion')); ?>:</b>
	<?php echo CHtml::encode(Presentacion::model()->findByPk($data->presentacion)->presentacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad_presentacion')); ?>:</b>
	<?php echo CHtml::encode($data->unidad_presentacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio_unitario')); ?>:</b>
	<?php echo CHtml::encode($data->precio_unitario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iva')); ?>:</b>
	<?php echo CHtml::encode($data->iva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trim_i')); ?>:</b>
	<?php echo CHtml::encode($data->trim_i); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trim_ii')); ?>:</b>
	<?php echo CHtml::encode($data->trim_ii); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trim_iii')); ?>:</b>
	<?php echo CHtml::encode($data->trim_iii); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trim_iv')); ?>:</b>
	<?php echo CHtml::encode($data->trim_iv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_total')); ?>:</b>
	<?php echo CHtml::encode($data->sub_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_iva')); ?>:</b>
	<?php echo CHtml::encode($data->total_iva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	*/ ?>

</div>