<?php
	$this->breadcrumbs=array(
		'Opciones'=>array('opciones'),
		'Registrar BD'
	);
?>
<h1>Registrar una Base de Datos</h1>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bd-form',
		'enableAjaxValidation'=>false
	)); ?>
		<p class="note">Registrar o eliminar una base de datos de la <b>lista de acceso</b><span class="required">*</span>.</p>
		
		<div id="bases">
			<table class="small collapsed">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Seleccionar</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($archivo as $key => $value)
						{
					?>
						<tr>
							<td><?php echo $value; ?></td>
							<td><?php echo CHtml::checkbox('base_datos['.$key.']','',array('value'=>$key)); ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>

		<br><!-- salto de linea -->

		<div class="buttons">
			<?php 
				$this->widget('zii.widgets.jui.CJuiButton', array(
				    'buttonType'=>'submit',
				    'name'=>'btnEliminar',
				    'value'=>'1',
				    'caption'=>'Eliminar registro',
				));
			?>
			<?php 
				$this->widget('zii.widgets.jui.CJuiButton', array(
				    'buttonType'=>'button',
				    'name'=>'btnAgregar',
				    'value'=>'1',
				    'caption'=>'Registrar nueva',
				    'onclick'=>new CJavaScriptExpression('function(){
				    	$("#dialog").load("'.CController::createUrl('registrar').'").dialog({
				    		title:"Registrar",
				    		modal:true,
				    		draggable:false,
				    		resizable:false,
				    		buttons:[{
				    			text:"Registrar",
				    			click: function(){
				    				$.ajax({
				    					type: "POST",
				    					url:"'.CController::createUrl('registrar').'",
				    					data: {nombre_base:$("#nombre_base").val()},
				    					success: function(){
				    						$("#bases").load("'.CController::createUrl('registrarBd').' #bases");
				    						$("#dialog").dialog("close");
				    					}				    					
				    				});
				    			}
				    		}]
				    	});
				    }')
				));
			?>
		</div>

	<?php $this->endWidget(); ?>

</div>
<div id="dialog"><!-- ventana modal --></div>

<br><!-- salto de linea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('site/opciones')); ?>