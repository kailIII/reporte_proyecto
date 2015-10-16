<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo),array('view','id'=>$data->codigo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_accion')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_accion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('presupuesto')); ?>:</b>
	<?php echo CHtml::encode($data->presupuesto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utilizado')); ?>:</b>
	<?php echo CHtml::encode($data->utilizado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_hora')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_hora); ?>
	<br />


</div>