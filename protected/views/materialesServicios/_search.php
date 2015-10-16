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
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precio1'); ?>
		<?php echo $form->textField($model,'precio1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subpartida'); ?>
		<?php echo $form->textField($model,'subpartida'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidad_medida'); ?>
		<?php echo $form->textField($model,'unidad_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'presentacion'); ?>
		<?php echo $form->textField($model,'presentacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->