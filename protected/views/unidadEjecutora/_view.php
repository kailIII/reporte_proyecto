<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_uel')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_uel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denominacion')); ?>:</b>
	<?php echo CHtml::encode($data->denominacion); ?>
	<br />


</div>