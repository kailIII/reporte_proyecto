<?php
$this->breadcrumbs=array(
	'Respaldos'=>array('default/index'),
	'Upload',
);?>
<h1>Cargar Respaldo</h1>

<div class="form">
<p>
	Subir un archivo de respaldo al servidor.
</p>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
		<div class="row">
		<?php echo $form->labelEx($model,'upload_file'); ?>
		<?php echo $form->fileField($model,'upload_file'); ?>
		<?php echo $form->error($model,'upload_file'); ?>
		</div><!-- row -->	

		<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>Yii::t('app', 'Cargar'),
			));
		?>
	</div>
<?php

	//echo CHtml::submitButton(Yii::t('app', 'Save'));
	$this->endWidget();
?>
</div><!-- form -->
<p> <?php echo CHtml::link('Volver', CController::createUrl('default/index'))?></p>