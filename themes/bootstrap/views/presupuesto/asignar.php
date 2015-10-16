<?php
	$this->breadcrumbs=array(
		'Presupuestos'=>array('index'),
		$modelo->codigo=>array('view','id'=>$modelo->codigo),
		'Asignar'
	);
?>
<h1>Asignar UEL al presupuesto</h1>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(		
		'id'=>'asignar-uel-presupuesto-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">
		Los campos con <span class="required">*</span> son requeridos.
	</p>

	<?php echo $form->errorSummary($accion_ue); ?>

	<div class="row">
		<label>Acción</label>
		<p>
			<?php echo Acciones::model()->findByPk($modelo->codigo_accion)->accion; ?>
		</p>
	</div>

	<div class="row">
		<label>Presupuesto</label>
		<p>
			<?php echo "Bs. ".$modelo->presupuesto; ?>
		</p>
	</div>

	<div class="row">
		<label><?php echo $form->labelEx($accion_ue,'codigo_ue'); ?></label>
		<?php echo $form->dropDownList($accion_ue,'codigo_ue',CHtml::listData($ue,'codigo','denominacion'),array(
			'empty'=>'(Seleccione la Unidad Ejecutora)'
		)); ?>
	</div>

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'Asignar',
			));
		?>
	</div>

	<?php $this->endWidget(); ?>
</div>

</br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('presupuesto/view', array('id'=>$modelo->codigo))); ?>