<div class="view">
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nivel')); ?>:</b>
	<?php echo CHtml::encode(Nivel::model()->findByPk($data->nivel)->nivel); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('uel')); ?>:</b>
	<?php echo CHtml::encode($data->uel==0? 'NO ASIGNADO' : UnidadEjecutora::model()->findByPk($data->uel)->denominacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estatus')); ?>:</b>
	<?php echo CHtml::encode($data->estatus==1? 'ACTIVO' : 'INACTIVO'); ?>
	<br />
	
</div>