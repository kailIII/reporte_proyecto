<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'materiales-servicios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio1'); ?>
		<?php echo $form->textField($model,'precio1'); ?>
		<?php echo $form->error($model,'precio1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio2'); ?>
		<?php echo $form->textField($model,'precio2'); ?>
		<?php echo $form->error($model,'precio2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio3'); ?>
		<?php echo $form->textField($model,'precio3'); ?>
		<?php echo $form->error($model,'precio3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio4'); ?>
		<?php echo $form->textField($model,'precio4'); ?>
		<?php echo $form->error($model,'precio4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subpartida'); ?>
		<?php echo $form->dropDownList($model,'subpartida',CHtml::listData(Subpartida::model()->findAll(),'codigo','descripcion'),array(
			'empty'=>'(Seleccione subpartida)'
			)); 
		?>
		<?php echo $form->error($model,'subpartida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidad_medida'); ?>
		<?php echo $form->dropDownList($model,'unidad_medida',CHtml::listData(UnidadMedida::model()->findAll(),'codigo','unidad_medida'),array(
			'empty'=>'(Seleccione unidad de medida)'
		)); ?>
		<?php echo $form->error($model,'unidad_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'presentacion'); ?>
		<?php echo $form->dropDownList($model,'presentacion',CHtml::listData(Presentacion::model()->findAll(),'codigo','presentacion'),array(
			'empty'=>'(Seleccione presentación)'
		)); ?>
		<?php echo $form->error($model,'presentacion'); ?>
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