<h2>Importar Materiales/Servicios</h2>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'materialesservicios-importar-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
	
)); ?>

	<p class="note">Cargar o actualizar materiales y/o servicios mediante un archivo CSV.</p>
	<p>
		<b>Instrucciones:</b> El archivo debe estar en el formato
		<table>
			<thead>
				<tr>
					<th>Partida</th>
					<th>GE</th>
					<th>ES</th>
					<th>SE</th>
					<th>Material o servicio</th>
					<th>Unidad de medida</th>
					<th>Presentación</th>
					<th>Precio</th>
				</tr>
			</thead>
		</table>
	</p>

	<div class="row">
		<?php echo $form->labelEx($modelo,'Archivo'); ?>
		<?php echo $form->fileField($modelo,'archivo'); ?>
		<?php echo $form->error($modelo,'codigo'); ?>
	</div>
	<?php
		if($_POST)
		{
	?>
	<div><?php echo $exito - $fallo ?> registros insertados/actualizados exitosamente.</div>
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

<br><!-- salto de linea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('site/opciones')); ?>