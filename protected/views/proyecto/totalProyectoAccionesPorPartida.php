<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Total partidas'
	);
?>

<h1>Total de los proyectos</h1>

<div class="form">

	<!-- Formulario -->
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'proyecto-form',
		'action'=>CController::createUrl('proyecto/imprimirTotalProyectoAccionesPorPartida'),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
	)); ?>

	<p class="note">Total de los proyectos, acciones y partidas principales.</p>

	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

	<div class="simple big">
		<span style="font-weight:bold">Total</span>:<?php echo " Bs. ".Yii::app()->format->number($totalProyectos); ?>
	</div>
	<?php
	
		//Por cada proyecto
		foreach ($proyectos as $llave => $proyecto)
		{
			
			//Proyecto
			$this->renderPartial('_proyecto',array(
				'proyecto'=>$proyecto, //Instancia de proyecto
				'total'=>$totalesProyectosAcciones[$proyecto['codigo']]['proyecto'] //Total del proyecto
			));
		
	?>
		<?php
			//Las acciones
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));

			//Por cada accion
			foreach($acciones as $key => $accion)
			{ 
				
		?>
		<!-- Accion -->
		<table class="collapsed medium">
			<thead>
				<tr>
					<th style="width:85px">Código Acción</th>
					<th>Nombre de la acción</th>
					<th style="width:118px">Total</th>
				</tr>
			</thead>
			<tbody>
		<?php

			//Accion
			$this->renderPartial('_accion', array(
				'accion'=>$accion, //instancia de accion
				'total'=>$totalAccion[$proyecto->codigo]['acciones'][$accion['codigo']] //Total de la accion
			));
			
		?>
			</tbody>
		</table>
		<?php
		//print_r($pP[$accion->codigo]);
		
			//Partidas
			$this->renderPartial('_accionPartidaGeneral', array(
				'pP'=>$pP,
				'valor'=>$accion,
				'iva'=>$iva,
			));
		
		?>
		<?php
			} //Fin foreach accion
		?>
		<div class="barra"></div><!--Separador-->
	<?php
		}//Fin foreach proyecto 
	?>

	</br><!-- Espacio -->

	<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->
	
	<br><!-- Salto de linea -->

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'Imprimir',
			));
		?>
	</div>
	<?php $this->endWidget(); ?><!-- Termina el formulario -->
</div>

</br><!-- Salto de linea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/index')); ?>