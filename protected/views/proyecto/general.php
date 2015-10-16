<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('index'),
		'Proyecto '.$proyecto->codigo=>array('view', 'id'=>$proyecto->codigo),
		'Reporte General',
	);
?>

<h1>Reporte General</h1>

<div class="form">

	<div class="simple right" id="toBottom"><a href="#toTop">Ir al final</a></div><!-- Para bajar -->

	<?php
		//Proyecto
		$this->renderPartial('_proyecto',array(
			'proyecto'=>$proyecto, //Instancia de proyecto
			'total'=>$totalProyecto['proyecto'] //Total del proyecto
		));
	?>

	<?php 
		//Por cada accion
		foreach ($acciones as $key => $accion)
		{			
	?>
		<br><!-- Salto de linea -->

		<!-- Formulario -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'proyecto-form_'.$accion->codigo,
			'action'=>CController::createUrl('proyecto/imprimirReporteGeneral',array('proyecto'=>$proyecto->codigo, 'accion'=>$accion->codigo)),
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>false,
			),
		)); ?>
		
		<?php 
			//Relacion Unidad Ejecutora - Accion
			foreach ($aue[$accion->codigo] as $j => $k) 
			{
				//Unidad Ejecutora
				$ue=UnidadEjecutora::model()->findByPk($k->codigo_ue);
		?>
			<?php
				//Unidad Ejecutora
				$this->renderPartial('_ue',array(
					'ue'=>$ue, //Instancia de unidad ejecutora
				));
			?>

			<br>
			<table class="collapsed medium"><!-- Accion -->
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
					'total'=>$totalProyectoAcciones[$proyecto->codigo]['acciones'][$accion['codigo']] //Total de la accion
				));					
			?>

				</tbody>
			</table> <!-- Accion -->

			<br><!-- Salto de linea -->


			<div class="row buttons">
				<?php 
					$this->widget('zii.widgets.jui.CJuiButton', array(
					    'buttonType'=>'submit',
					    'name'=>'btnSubmit_'.$accion['codigo'],
					    'value'=>'1',
					    'caption'=>'PDF',
					));
				?>
				<?php 
					$this->widget('zii.widgets.jui.CJuiButton', array(
					    'buttonType'=>'button',
					    'name'=>'btnExcel_'.$accion['codigo'],
					    'value'=>'1',
					    'caption'=>'Hoja de cálculo',
					    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('proyecto/reporteGeneralExcel', array('proyecto'=>$proyecto->codigo, 'accion'=>$accion['codigo'])).'";}'),
					));
				?>
			</div>
			
			<?php $this->endWidget(); ?><!-- Termina el formulario -->

			<?php
			/*			
				//Registros			
				$this->renderPartial('_planificacion',array(
					'registros'=>$registros[$accion->codigo][$k->codigo], //Registros por accion - unidad ejecutora
					'codigo_accion'=>$accion['codigo']
				),false,true);
			*/				
			?>
							
		<?php	 
			} //Fin Relacion Unidad Ejecutora - Accion
			
		?>

	<?php
		} //Fin por cada accion
	?>

</div>

</br><!-- Espacio -->

<div class="simple right" id="toTop"><a href="#banner">Ir al principio</a></div><!-- Para subir -->

<br><!-- Espacio -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>