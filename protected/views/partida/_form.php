<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'partida-form',
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		//'beforeValidate'=>new CJavaScriptExpression(),
	),
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'partida'); ?>
		<?php echo $form->textField($model,'partida',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'partida'); ?>
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

<!-- Dialogo de mensajes -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'existePartida',
		'options'=>array(
			'title'=>'Advertencia',
			'autoOpen'=>false,
			'draggable'=>false,
			'resizable'=>false,
			'modal'=>true,
			'buttons'=>array(
				'Cerrar'=>'js:function(){$(this).dialog("close")}'
			)
		),
	));
?>
<!-- Mensaje -->
<p>La partida ya existe.</p>

<?php
	//Termina el dialogo
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>