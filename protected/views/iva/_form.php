<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'iva-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'iva'); ?>
		<?php echo $form->textField($model,'iva'); ?>
		<?php echo $form->error($model,'iva'); ?>
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