<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Trimestral'
	);
?>

<h1>General Trimestral</h1>

<div class="form">
	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

		<!-- Formulario -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'general-trimestral-form',
			//'action'=>CController::createUrl('proyecto/trimestralPdf',array('proyecto'=>'')),
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>false,
			),
		)); ?>

	<?php
		
		foreach ($proyectos as $llave => $proyecto)
		{
			//Acciones
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));
			
			//Montos trimestrales
			$trimestral=$this->devolverTrimestral($acciones);
			//Iva trimestral
			$iva=$this->devolverTrimestralIva($acciones);

			$this->renderPartial('_generalTrimestral',array('proyecto'=>$proyecto,'trimestral'=>$trimestral,'iva'=>$iva));
		}
	?>

	<div class="row buttons">		
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'button',
			    'name'=>'btnExcel',
			    'caption'=>'Hoja de cálculo',
			    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/generalTrimestralExcel').'";}'),
			));
		?>
	</div>

	<?php $this->endWidget(); ?><!-- Termina el formulario -->
</div>

<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->