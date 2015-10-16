<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo,'accion'=>$accion,'proyecto'=>$proyecto)); ?>
	<br />

	<b><?php echo CHtml::encode('Unidad Ejecutora'); ?>:</b>
	<?php echo CHtml::encode(UnidadEjecutora::model()->findByPk($data->codigo_ue)->denominacion); ?>
	<br />


</div>