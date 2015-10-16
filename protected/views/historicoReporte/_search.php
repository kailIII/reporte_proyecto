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
		<?php echo $form->label($model,'codigo_reporte'); ?>
		<?php echo $form->textField($model,'codigo_reporte'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codigo_usuario'); ?>
		<?php echo $form->textField($model,'codigo_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operacion'); ?>
		<?php echo $form->textField($model,'operacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->