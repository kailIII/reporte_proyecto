<?php
	$this->breadcrumbs=array(
		'Proyectos'=>array('proyecto/index'),
		'Proyecto #'.$proyecto->codigo=>array('proyecto/view','id'=>$proyecto->codigo),
		'Total partidas'
	);
?>

<h1>Total por unidad ejecutora</h1>

<div class="form">

	<p class="note">El total del proyecto, el total de la acción y las partidas por unidad ejecutora.</p>

	<?php
		//Proyecto
		$this->renderPartial('_proyecto',array(
			'proyecto'=>$proyecto, //Instancia de proyecto
			'total'=>$totalProyecto['proyecto'] //Total del proyecto
		));
	?>
	<!-- Formulario -->
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'proyecto-form',
		'action'=>CController::createUrl('proyecto/imprimirPorUe',array('proyecto'=>$proyecto->codigo)),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
	)); ?>
	<div class="row">
		<!-- Lista de acciones asociadas al proyecto -->
		<label>Acción:</label>
		<?php echo CHtml::dropDownList('accion','',CHtml::listData($acciones, 'codigo','accion'),array(
			'empty'=>'(Seleccione una acción)',
			'style'=>'width:200px',
			'ajax'=>array(
				'update'=>'#unidad_ejecutora',
				'type'=>'POST',
				'url'=>CController::createUrl('proyecto/unidadEjecutora',array(
					'proyecto'=>$proyecto->codigo,
				))
			)
		)); ?>
	</div>

	<div class="row">
		<!-- Lista de unidades ejecutoras -->
		<label>Unidad Ejecutora:</label>
		<?php echo CHtml::dropDownList('unidad_ejecutora','',array(),array(
			'empty'=>'(Seleccione una Unidad Ejecutora)',
			'ajax'=>array(
				'update'=>'#totalAccionUe',
				'type'=>'POST',
				'url'=>CController::createUrl('proyecto/porUeAccion',array(
					'proyecto'=>$proyecto->codigo
				))
			)
		)); ?>
	</div>

	<div id="totalAccionUe"><!-- La acción -->	</div>

	<?php $this->endWidget(); ?><!-- Termina el formulario -->

</div>

</br><!-- Salto de linea -->

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>