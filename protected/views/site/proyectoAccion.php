<?php
	$this->breadcrumbs=array(
		'Proyectos y acciones',
	);
?>

<h2>Cargar Proyectos y acciones</h2>

<div class="form">

	<p class="note">Cargar o importar proyectos y sus acciones asociadas mediante un archivo CSV.</p>
	<p>
		<b>Instrucciones:</b> El archivo debe estar en el formato 
		<table>
			<thead>
				<tr>
					<th>codigo_sne</th>
					<th>nombre_proyecto</th>
					<th>codigo_accion</th>
					<th>nombre_accion</th>
					<th>codigo_unidad_ejecutora</th>
					<th>nombre_unidad_ejecutora</th>
				</tr>
			</thead>
		</table>
		y no poseer saltos de línea en el nombre del proyecto, acción o unidad ejecutora.
	</p>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'proyectoaccion-importar-form',
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
	<div><?php echo $exito ?> registros insertados o actualizados exitosamente.</div>
	<?php
		}
	?>

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'Cargar',
			));
		?>
	</div>

<?php $this->endWidget(); ?>

</div>

<br><!-- salto de linea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('site/opciones')); ?>