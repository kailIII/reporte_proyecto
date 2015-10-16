<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clave'); ?>
		<?php echo $form->textField($model,'clave',array('size'=>32,'maxlength'=>32,'value'=>'')); ?>
		<?php echo $form->error($model,'clave'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nivel'); ?>
		<?php echo $form->dropDownList($model,'nivel',CHtml::listData(Nivel::model()->findAll(),'codigo','nivel'),array(
				'empty'=>'(Seleccione un nivel)',
		)); ?>
		<?php echo $form->error($model,'nivel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uel'); ?>
		<?php echo $form->dropDownList($model,'uel',CHtml::listData(UnidadEjecutora::model()->findAll(array('order'=>'denominacion ASC')),'codigo','denominacion'),array(
				'empty'=>'(Seleccione una Unidad Ejecutora)',
		)); ?>
		<?php echo $form->error($model,'uel'); ?>
	</div>
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'estatus'); ?>
		<?php echo $form->dropDownList($model,'estatus',CHtml::listData(Estatus::model()->findAll(),'codigo','estatus'),array(
			'empty'=>'(Seleccione un Estatus)'
		)); ?>
		<?php echo $form->error($model,'estatus'); ?>
	</div>
	-->
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