<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Total proyectos'
	);
?>

<h1>Total <?php echo $PRYACC; ?></h1>

<div class="form">

	<!-- Formulario -->
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'proyecto-form',
		'action'=>CController::createUrl('proyecto/imprimirTotalProyectosPorPartida',array('tipo'=>$tipo)),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
	)); ?>

	<p class="note"><?php echo $PRYACC; ?> y sus partidas principales.</p>

	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

	<div class="simple big">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalProyectos); ?>
	</div>
	<?php
		//Por cada proyecto
		foreach ($proyectos as $llave => $valor)
		{
			//Proyecto
			$this->renderPartial('_proyecto',array(
				'proyecto'=>$valor, //Instancia de proyecto
				'total'=>$totalesProyectosAcciones[$valor['codigo']]['proyecto'] //Total del proyecto
			));

	?>
	<?php if(!empty($pP[$valor->codigo])): ?>

		<table class="collapsed medium">
			<thead>
				<tr>
					<th style="width:85px">Partida</th>
					<th>Descripción</th>
					<th style="width:118px">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//Inicializar variables para sumar y contar
					$anterior=null;
					$totalizar=0;

					//Obtener el final del arreglo para referencia
					end($pP[$valor->codigo]); //Colocar el puntero al final del arreglo
					$last=key($pP[$valor->codigo]); //Obtener la ultima llave


					foreach ($pP[$valor->codigo] as $key => $value)
					{
						//Extraer la partida
						$partida=$value['imputacion_presupuestaria'];
						$partida=$partida[0].$partida[1].$partida[2];

						
						if($partida > '403' && $anterior==null)
						{
							$totalizar=$totalizar+$iva[$valor->codigo]['iva'];

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>403</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							$totalizar=0;
						}
						

						if($anterior!=$partida && $anterior!=null)
						{

							if($anterior=='403')
							{
								$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							}

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>'.$anterior.'</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>$anterior))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							//Restaurar el valor inicial
							$totalizar=0;
						}

						if($partida == '404' && $anterior == '402')
						{
							$totalizar=$iva[$valor->codigo]['iva']; //Solo el IVA

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>403</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion partida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							//Restaurar el valor inicial
							$totalizar=0;
						}
						
						//Sumar
						$totalizar=$totalizar+$value['total'];

						if($last == $key) //Si es el final del arreglo
						{
							if($partida=='403')
							{
								$totalizar=$totalizar+$iva[$valor->codigo]['iva'];
							}

							echo '<tr style="background-color:#e3e3e3">';
							echo '<td>'.$partida.'</td>'; //Partida
							echo '<td>'.Partida::model()->findByAttributes(array('partida'=>$partida))->descripcion.'</td>'; //Descripcion patida
							echo '<td style="text-align:right">'.Yii::app()->format->number($totalizar).'</td>'; //Total
							echo '</tr>';

							if($partida<'403')
							{
								echo '<tr style="background-color:#e3e3e3">';
								echo '<td>403</td>'; //Partida
								echo '<td>'.Partida::model()->findByAttributes(array('partida'=>'403'))->descripcion.'</td>'; //Descripcion patida
								echo '<td style="text-align:right">'.Yii::app()->format->number($iva[$valor->codigo]['iva']).'</td>'; //IVA
								echo '</tr>';
							}

							//Restaurar el valor inicial
							$totalizar=0;
							
						}
						//Partida actual de referencia
						$anterior=$partida;
					}
				?>
			</tbody>
		</table>
	<?php else: ?>
		<div style="border:1px solid #DDDDDD; padding:5px 5px;text-align:center">Datos No Disponibles.</div>
	<?php endif; ?>
	<div class="barra"></div><!--Separador-->
	<?php
		} //Fin foreach cada proyecto
	?>
</div>

</br><!-- Espacio -->

<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->

<br><!-- Salto de línea -->

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
		    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/imprimirTotalProyectosPorPartidaExcel', array('tipo'=>$tipo)).'";}'),
		));
	?>
</div>

<?php $this->endWidget(); ?><!-- Termina el formulario -->

</br><!-- Salto de línea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/totalProyectosPorPartidaSelect')); ?>