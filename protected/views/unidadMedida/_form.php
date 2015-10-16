<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'unidad-medida-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'unidad_medida'); ?>
		<?php echo $form->textField($model,'unidad_medida',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'unidad_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo',CHtml::listData(TipoUnidadMedida::model()->findAll(),'codigo','tipo'), array(
			'empty'=>'(Seleccione un tipo)'
		)); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'estatus',array('value'=>1)); ?>
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