<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reporte-form',
	'focus'=>'#materialServicio',
	'enableAjaxValidation'=>false,
	'clientOptions' => array(
      'validateOnSubmit'=>true,
      'afterValidate'=>'js:function(){$(".agrupados").css("background-color","green")}',
      ),
)); ?>

	<!-- Mensaje -->
	<?php if(Yii::app()->user->hasFlash('usuario')): ?>

		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('usuario'); ?>
		</div>

	<?php endif; ?>

	<?php

		if(Yii::app()->user->nivel==1) // Si es administrador
		{
			//accion_ue
			$aue=AccionUe::model()->find(array(
				'condition'=>'codigo=:codigo',
				'params'=>array(':codigo'=>$model->accion_ue)
			));
		}
		else //Si no es administrador
		{
			//accion_ue
			$aue=AccionUe::model()->find(array(
				'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
				'params'=>array(':codigo_accion'=>$accion,':codigo_ue'=>Yii::app()->user->uel)
			));
		}


		//Total de reporte para el estimado
		$estimado=Reporte::model()->findBySql('SELECT SUM(total) AS total FROM reporte WHERE accion_ue = :accion_ue AND estatus= :estatus',array(
			':accion_ue'=>$aue->codigo,
			':estatus'=>1
		));
		//presupuesto
		/*
		$presupuesto=Presupuesto::model()->findByPk($aue->presupuesto);
		*/
	?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<!--El Presupuesto -->
	<div id="estimado">
		
			Total Estimado:
			<span><?php echo "Bs. ".Yii::app()->format->number($estimado->total); ?></span>


		<?php /*
		<div class="row">
			<label>Presupuesto:</label>
			<?php echo "Bs. ".$presupuesto->presupuesto; ?>
		</div>
		
		<div class="row">
			<label>Total Estimado:</label>
			<?php echo "Bs. ".$presupuesto->utilizado; ?>
		</div>
		
		<div class="row">
			<label>Restante:</label>
			<?php echo "Bs. ".($presupuesto->presupuesto - $presupuesto->utilizado); ?>
			<?php echo CHtml::hiddenField('restante',($presupuesto->presupuesto - $presupuesto->utilizado)); ?>
		</div>
		*/ ?>

	</div>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'accion_ue', array('value'=>$aue->codigo)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'material_servicio'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			    'name'=>'materialServicio',
			    'attribute'=>'value',
			    'value'=>$value,
			    'source'=>$this->createUrl('devuelveMaterial', array('accion'=>$accion,'proyecto'=>$proyecto)),
			    // additional javascript options for the autocomplete plugin
			    'options'=>array(
			        'minLength'=>'3',
			        'select'=>"js:function(event,ui){
			        	$('#Reporte_material_servicio').val(ui.item.codigo);
			        	$('#Reporte_imputacion_presupuestaria').val(ui.item.Imputacion);
			        	$('#partida').html(ui.item.partida);
			        	$('#Reporte_precio_unitario').val(ui.item.precio1);
			        	$('#Reporte_unidad_medida').val(ui.item.unidad_medida);
			        	$('#unidad_medida').val(ui.item.um_descripcion);
			        	$('#Reporte_presentacion').val(ui.item.presentacion);
			        	$('#presentacion').val(ui.item.p_presentacion);
			        }",
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			        'size'=>48,
			        'id'=>'materialServicio'
			    ),
			));

		?>
		<?php echo $form->hiddenField($model,'material_servicio'); ?>
		<?php echo $form->error($model,'material_servicio'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'imputacion_presupuestaria'); ?>
		<?php echo $form->textField($model,'imputacion_presupuestaria',array('size'=>9,'maxlength'=>9,'readonly'=>true,'class'=>'noinput')); ?>
		<?php echo $form->error($model,'imputacion_presupuestaria'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidad_medida'); ?>
		<?php echo CHtml::textField('unidad_medida','',array('readonly'=>'readonly','class'=>'noinput')); ?>
		<?php echo $form->hiddenField($model,'unidad_medida'); ?><!-- Campo oculto -->
		<?php echo $form->error($model,'unidad_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'presentacion'); ?>
		<?php echo CHtml::textField('presentacion','',array('readonly'=>'readonly','class'=>'noinput')); ?>
		<?php echo $form->hiddenField($model,'presentacion'); ?><!-- Campo oculto -->
		<?php echo $form->error($model,'presentacion'); ?>
	</div>
	<?php
	/** Unidad por presentacion
	<div class="row">
		<?php echo $form->labelEx($model,'unidad_presentacion'); ?>
		<?php echo $form->textField($model,'unidad_presentacion'); ?>
		<?php echo $form->error($model,'unidad_presentacion'); ?>
	</div>
	**/
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'precio_unitario'); ?>
		<?php echo $form->textField($model,'precio_unitario', array('readonly'=>'readonly','class'=>'noinput')); ?>
		<div id="Precio" style="display:inline"></div><!-- El precio sugerido -->
		<?php echo $form->error($model,'precio_unitario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iva'); ?>
		<?php if($model->codigo==null){$model->iva=12;} ?><!-- IVA por defecto -->

		<?php if(Yii::app()->user->nivel==1): ?>
			<?php echo $form->textField($model, 'iva', array('style'=>'width:15px')); ?>
		<?php else: ?>
			<?php echo $form->textField($model, 'iva', array('readonly'=>true,'class'=>'noinput','style'=>'width:15px')); ?>
		<?php endif; ?>
		<span>%</span>
		<?php echo $form->error($model,'iva'); ?>
	</div>

</div>

<div class="form">
	<span style="text-align:center"><label>Unidades del material o servicio por trimestre<span class="required">*</span></label></span>
</div>

<div class="agrupados">
	<table>
		<tr>
			<td>
				<?php echo $form->labelEx($model,'trim_i'); ?>
			</td>
			<td>
				<?php echo $form->numberField($model,'trim_i',array('class'=>'trim','min'=>0)); ?>
				<?php echo $form->error($model,'trim_i'); ?>
			</td>
			<td>
				<?php echo $form->labelEx($model,'trim_ii'); ?>
			</td>
			<td>
				<?php echo $form->numberField($model,'trim_ii',array('class'=>'trim','min'=>0)); ?>
				<?php echo $form->error($model,'trim_ii'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->labelEx($model,'trim_iii'); ?>
			</td>
			<td>
				<?php echo $form->numberField($model,'trim_iii',array('class'=>'trim','min'=>0)); ?>
				<?php echo $form->error($model,'trim_iii'); ?>
			</td>
			<td>
				<?php echo $form->labelEx($model,'trim_iv'); ?>
			</td>
			<td>
				<?php echo $form->numberField($model,'trim_iv',array('class'=>'trim','min'=>0)); ?>
				<?php echo $form->error($model,'trim_iv'); ?>
			</td>
		</tr>
	</table>
</div>


<div class="wide form">
	<div class="row">
		<label>Trim total</label>
		<?php echo CHtml::textField('trim_total','',array('id'=>'trim_total','readonly'=>true,'class'=>'noinput')); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'sub_total'); ?>
		<?php echo $form->textField($model,'sub_total',array('readonly'=>true,'class'=>'noinput')); ?>
		<?php echo $form->error($model,'sub_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_iva'); ?>
		<?php echo $form->textField($model,'total_iva',array('readonly'=>true,'class'=>'noinput')); ?>
		<?php echo $form->error($model,'total_iva'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('readonly'=>true,'class'=>'noinput')); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row buttons">
		<?php 
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>$model->isNewRecord ? 'Guardar' : 'Actualizar',
			));
		?>
	</div>

<?php $this->endWidget(); ?>

<!-- Invocar la funcion JavaScript para sumar -->
<script type="text/javascript">
	$(document).ready(function(){

		trimTotal('.trim');
		valorDefecto('.trim');

		//Impedir dejar los campos vacíos
		$('#Reporte_trim_i').keyup(function(){if($(this).val() == ''){$(this).val(0)}});
		$('#Reporte_trim_ii').keyup(function(){if($(this).val() == ''){$(this).val(0)}});
		$('#Reporte_trim_iii').keyup(function(){if($(this).val() == ''){$(this).val(0)}});
		$('#Reporte_trim_iv').keyup(function(){if($(this).val() == ''){$(this).val(0)}});

		/* Eventos */
		$('#Reporte_iva').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_precio_unitario').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_precio_unitario').keyup(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});

		//Trim I
		$('#Reporte_trim_i').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_trim_i').keyup(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		//Trim II
		$('#Reporte_trim_ii').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_trim_ii').keyup(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		//Trim III
		$('#Reporte_trim_iii').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_trim_iii').keyup(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		//Trim IV
		$('#Reporte_trim_iv').change(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		$('#Reporte_trim_iv').keyup(function(){calcular('.trim','#Reporte_sub_total','#Reporte_precio_unitario','#Reporte_iva','#Reporte_total_iva','#Reporte_total')});
		
	});
</script>
<!--
<?php if(Yii::app()->user->nivel!=1): ?>
	<div id="agregados">
		<?php echo $this->renderPartial('_agregados',array('accion'=>$accion)); ?>
	</div>
<?php endif; ?>
-->
</div><!-- form -->