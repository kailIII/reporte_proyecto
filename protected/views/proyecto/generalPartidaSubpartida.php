<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('proyecto/index'),
);
?>
<h1>General por Partida y Subpartidas</h1>

<div class="form">
	<p class="note">Total general (Proyectos y Acciones Centralizadas) con detalle de las partidas.</p>

<?php
	if($proyectos == null || $proyectos == ''): //Si no hay registros
?>
	<!-- Mensaje -->
	<div class="flash-notice">
		No hay registros.
	</div>

<?php else: ?>

	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

	<!-- Formulario -->
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'trimestral-form',
		'action'=>CController::createUrl('proyecto/generalPartidaSubpartidaPDF'),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
	)); ?>

	<div class="simple big">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalGeneral); ?>
	</div>

	<table class="collapsed medium">
		<thead>
			<tr>
				<th>Partida</th>
				<th>GE</th>
				<th>ES</th>
				<th>SE</th>
				<th>Denominación</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				//Para totalizar el IVA
				$ivaTotal = 0;

				foreach ($totalSubpartidas as $key => $value)
				{
					$imputacion=$value['imputacion_presupuestaria'];

					if(substr($imputacion, 3)=='000000')
					{
						//Sumar el iva al total general de la partida 403
						if($imputacion=='403000000'){$adicional=$iva['iva'];}else{$adicional=0;}

						$this->renderPartial('imprimir/_partidaGeneral',array(
							'partida'=>$imputacion,
							'ge'=>'00',
							'es'=>'00',
							'se'=>'00',
							'total'=>$totalPartida[$imputacion[0].$imputacion[1].$imputacion[2]]['total']+$adicional,
							'marked'=>true
						));
					}else
					{
						if($imputacion == '403180100') //Partida que contiene el IVA
						{
							$this->renderPartial('imprimir/_partida',array(
								'partida'=>$imputacion,
								'total'=>$value['total']+$iva['iva']
							));
						}
						else
						{
							$this->renderPartial('imprimir/_partida',array(
								'partida'=>$imputacion,
								'total'=>$value['total']
							));
						}
					}	
				}
			?>
		</tbody>
	</table>

	<br><!-- Sato de linea -->

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'PDF',
			));
		?>
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'button',
			    'name'=>'btnExcel',
			    'caption'=>'Hoja de cálculo',
			    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/generalPartidaSubpartidaExcel').'";}'),
			));
		?>
	</div>

</div><!--form-->

<?php $this->endWidget(); ?><!-- Termina el formulario -->
	
	<br><!-- Sato de linea -->

	<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->

<?php endif; ?><!-- Termina la condicion -->

<br><!-- Sato de linea -->
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/index')); ?>