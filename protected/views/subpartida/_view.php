<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('partida')); ?>:</b>
	<?php echo CHtml::encode($data->partida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ge')); ?>:</b>
	<?php echo CHtml::encode($data->ge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es')); ?>:</b>
	<?php echo CHtml::encode($data->es); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('se')); ?>:</b>
	<?php echo CHtml::encode($data->se); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />


</div>