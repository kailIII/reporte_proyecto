<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'acciones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_accion'); ?>
		<?php echo $form->textField($model,'codigo_accion'); ?>
		<?php echo $form->error($model,'codigo_accion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accion'); ?>
		<?php echo $form->textArea($model,'accion',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'accion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_proyecto'); ?>
		<?php echo $form->textField($model,'codigo_proyecto',array('readonly'=>true)); ?>
		<?php echo $form->error($model,'codigo_proyecto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estatus'); ?>
		<?php echo $form->dropDownList($model,'estatus', CHtml::listData(Estatus::model()->findAll(),'codigo','estatus'), array(
			'empty'=>'(Seleccione un estatus)',
		)); ?>
		<?php echo $form->error($model,'estatus'); ?>
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