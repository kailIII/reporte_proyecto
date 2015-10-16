<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accion-ue-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_accion'); ?>
		<?php echo $form->textField($model,'codigo_accion',array('readonly'=>true)); ?>
		<?php echo $form->error($model,'codigo_accion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_ue'); ?>
		<?php echo $form->dropDownList($model,'codigo_ue',CHtml::listData(UnidadEjecutora::model()->findAll(array('order'=>'denominacion ASC')),'codigo','denominacion'),array(
			'empty'=>'(Seleccione una Unidad Ejecutora)'
		)); ?>
		<?php echo $form->error($model,'codigo_ue'); ?>
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