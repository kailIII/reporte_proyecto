<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Proyecto #'.$proyecto->codigo=>array('proyecto/view','id'=>$proyecto->codigo),
		'Trimestral'
	);
?>
<h1>Trimestral</h1>

<div class="form">
	<p class="note">Montos trimestrales del proyecto por partida.</p>

	<?php
		if($trimestral == null || $trimestral == ''): //Si no hay registros
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
		'action'=>CController::createUrl('proyecto/trimestralPdf',array('proyecto'=>$proyecto->codigo)),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
	)); ?>

	<table class="collapsed medium"><!-- Proyecto -->
		<thead>
			<tr>
				<th style="width:85px">Código SNE</th>
				<th>Nombre del proyecto</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $proyecto->codigo_sne; ?></td>
				<td><?php echo $proyecto->nombre; ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="collapsed medium"><!-- Acciones -->
		<thead>
			<tr>
				<th>Acciones Específicas</th>
				<th>Partida</th>
				<th>Denominación</th>
				<th>I</th>
				<th>II</th>
				<th>III</th>
				<th>IV</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				//Totalizadores generales
				$total_trim_i=0; 
				$total_trim_ii=0; 
				$total_trim_iii=0; 
				$total_trim_iv=0;
				$total_total=0;

				foreach ($trimestral as $key => &$accion) 
				{
					//Longitud de la columna con el nombre de la accion
					$rowspan=count($accion)+1;

					//Totalizadores
					$trim_i=0; 
					$trim_ii=0; 
					$trim_iii=0; 
					$trim_iv=0;
					$total=0;
					foreach ($accion as $llave => $valor) 
					{
						//if(array_values($accion)[0] == $valor) PHP 5.4+
						if(array_shift(array_slice($accion, 0, 1)) == $valor)
						{
							//nombre de la accion
							echo "<tr><td rowspan='".$rowspan."' style='width:50%'>".$valor['accion']."</td></tr>";
						}

						if($valor['partida']=='403')
						{
							$valor['trim_i']=$valor['trim_i']+$iva[$key]['iva_trim_i'];
							$valor['trim_ii']=$valor['trim_ii']+$iva[$key]['iva_trim_ii'];
							$valor['trim_iii']=$valor['trim_iii']+$iva[$key]['iva_trim_iii'];
							$valor['trim_iv']=$valor['trim_iv']+$iva[$key]['iva_trim_iv'];
							$valor['total']=$valor['total']+$iva[$key]['iva_total'];
						}
						
						//Partida, denominacion, I, II, III, IV, Total
						$this->renderPartial('_trimestral',array('value'=>$valor));
						//Sumar para totalizar la accion
						$trim_i=$trim_i+$valor['trim_i'];
						$trim_ii=$trim_ii+$valor['trim_ii'];
						$trim_iii=$trim_iii+$valor['trim_iii'];
						$trim_iv=$trim_iv+$valor['trim_iv'];
						$total=$total+$valor['total'];

					}//var_dump($trimestral[$key]);echo "<br><br><br>";


			?>
					<!-- Totalizar la accion -->
					<tr style="background-color:#e3e3e3">
						<td colspan='3' style="text-align:center;font-weight:bold">Total Acción:</td>
						<td style="font-weight:bold"><?php echo Yii::app()->format->number($trim_i); ?></td>
						<td style="font-weight:bold"><?php echo Yii::app()->format->number($trim_ii); ?></td>
						<td style="font-weight:bold"><?php echo Yii::app()->format->number($trim_iii); ?></td>
						<td style="font-weight:bold"><?php echo Yii::app()->format->number($trim_iv); ?></td>
						<td style="font-weight:bold"><?php echo Yii::app()->format->number($total); ?></td>
					</tr>
			<?php
					//Sumar para totalizar el proyecto
					$total_trim_i=$total_trim_i+$trim_i;
					$total_trim_ii=$total_trim_ii+$trim_ii;
					$total_trim_iii=$total_trim_iii+$trim_iii;
					$total_trim_iv=$total_trim_iv+$trim_iv;
					$total_total=$total_total+$total;					
				}
			?>
			<!-- Totalizar el proyecto -->
			<tr style="background-color:#c3d9ff">
				<td colspan='3' style="text-align:center;font-weight:bold">Total Proyecto:</td>
				<td style="font-weight:bold"><?php echo Yii::app()->format->number($total_trim_i); ?></td>
				<td style="font-weight:bold"><?php echo Yii::app()->format->number($total_trim_ii); ?></td>
				<td style="font-weight:bold"><?php echo Yii::app()->format->number($total_trim_iii); ?></td>
				<td style="font-weight:bold"><?php echo Yii::app()->format->number($total_trim_iv); ?></td>
				<td style="font-weight:bold"><?php echo Yii::app()->format->number($total_total); ?></td>
			</tr>
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
			    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/trimestralExcel', array('proyecto'=>$proyecto->codigo)).'";}'),
			));
		?>
	</div>

	<?php $this->endWidget(); ?><!-- Termina el formulario -->

</div>

<br><!-- Sato de linea -->

<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->

<?php endif; ?><!-- Termina la condicion -->

<br><!-- Sato de linea -->
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>