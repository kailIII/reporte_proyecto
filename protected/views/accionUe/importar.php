<h2>Actualizar Acción Ue</h2>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'materialesservicios-importar-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
	
)); ?>

	<div class="row">
		<?php echo $form->labelEx($modelo,'Archivo'); ?>
		<?php echo $form->fileField($modelo,'archivo'); ?>
		<?php echo $form->error($modelo,'codigo'); ?>
	</div>
	<?php
		if($_POST)
		{
	?>
	<div><?php echo $exito - $fallo ?> registros insertados exitósamente.</div>
	<div><?php echo $fallo ?> registros defectuosos.</div>
	<?php
		}
	?>

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'Importar',
			));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->