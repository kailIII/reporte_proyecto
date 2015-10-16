<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accion_ue'); ?>
		<?php echo $form->textField($model,'accion_ue'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imputacion_presupuestaria'); ?>
		<?php echo $form->textField($model,'imputacion_presupuestaria',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'material_servicio'); ?>
		<?php echo $form->textField($model,'material_servicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidad_medida'); ?>
		<?php echo $form->textField($model,'unidad_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'presentacion'); ?>
		<?php echo $form->textField($model,'presentacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidad_presentacion'); ?>
		<?php echo $form->textField($model,'unidad_presentacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio_unitario'); ?>
		<?php echo $form->textField($model,'precio_unitario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iva'); ?>
		<?php echo $form->textField($model,'iva'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trim_i'); ?>
		<?php echo $form->textField($model,'trim_i'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trim_ii'); ?>
		<?php echo $form->textField($model,'trim_ii'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trim_iii'); ?>
		<?php echo $form->textField($model,'trim_iii'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trim_iv'); ?>
		<?php echo $form->textField($model,'trim_iv'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sub_total'); ?>
		<?php echo $form->textField($model,'sub_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_iva'); ?>
		<?php echo $form->textField($model,'total_iva'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total'); ?>
		<?php echo $form->textField($model,'total'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->