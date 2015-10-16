<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subpartida-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'partida'); ?>
		<?php echo $form->textField($model,'partida',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'partida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ge'); ?>
		<?php echo $form->textField($model,'ge',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'ge'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'es'); ?>
		<?php echo $form->textField($model,'es',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'es'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'se'); ?>
		<?php echo $form->textField($model,'se',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'se'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>$model->isNewRecord ? 'Guardar' : 'Actualizar',
			));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->