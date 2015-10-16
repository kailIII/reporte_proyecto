<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->codigo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('precio1')); ?>:</b>
	<?php echo CHtml::encode($data->precio1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subpartida')); ?>:</b>
	<?php echo CHtml::encode(Subpartida::model()->findByPk($data->subpartida)->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad_medida')); ?>:</b>
	<?php echo CHtml::encode(UnidadMedida::model()->findByPk($data->unidad_medida)->unidad_medida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('presentacion')); ?>:</b>
	<?php echo CHtml::encode(Presentacion::model()->findByPk($data->presentacion)->presentacion); ?>
	<br />


</div>