	<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('proyecto/index'),
	'Proyecto '.$proyecto=>array('proyecto/view','id'=>$proyecto),
	'Acción '.$model->codigo,
);

if(Yii::app()->user->nivel==1) //Si es administrador
{
	$this->menu=array(
		array('label'=>'Actualizar Acción', 'url'=>array('update', 'id'=>$model->codigo,'proyecto'=>$proyecto)),
		array('label'=>'Eliminar Acción', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo,'proyecto'=>$proyecto),'confirm'=>'¿Está seguro que desea eliminar esta acción? Los registros asociados serán eliminados')),
		array('label'=>'Asignar UE','url'=>array('accionUe/create','accion'=>$model->codigo,'proyecto'=>$proyecto)),
		array('label'=>'Lista de UE asignadas', 'url'=>array('accionUe/index', 'accion'=>$model->codigo, 'proyecto'=>$proyecto))
	);

	//Segundo menu con las acciones
	$this->menu2=array(
		array('label'=>'Registrar Material/Servicio', 'url'=>array('reporte/create','accion'=>$model->codigo,'proyecto'=>$proyecto)),
		array('label'=>'Lista de Registros', 'url'=>array('reporte/index', 'accion'=>$model->codigo,'proyecto'=>$proyecto)),
		/** Quitar comentario para usar el módulo de búsqueda **/
		//array('label'=>'Buscar Registros', 'url'=>array('reporte/admin','accion'=>$model->codigo,'proyecto'=>$proyecto)),
	);
}

if(Yii::app()->user->nivel==2) //Si es avanzado
{
	//Para buscar la existencia de presupuesto
	$aue=AccionUe::model()->find(array(
		'condition'=>'codigo_accion=:accion AND codigo_ue=:codigo_ue',
		'params'=>array(':accion'=>$model->codigo,':codigo_ue'=>Yii::app()->user->uel)
	));

	//Para determinar si tiene presupuesto
	/*
	if($aue->presupuesto != NULL){$tiene=true;}
	else{$tiene=false;}
	*/
	//Segundo menu con las acciones
	$this->menu2=array(
		/** Este código verifica la existencia de presupuesto **/
		/*
		array('label'=>'Registrar Material/Servicio', 'url'=>array('reporte/create','accion'=>$model->codigo,'proyecto'=>$proyecto),
			'linkOptions'=>array(
				'onclick'=>$tiene==false?"$('#noPresupuesto').dialog('open');return false":"#",
			),
		),
		*/
		array('label'=>'Registrar Material/Servicio', 'url'=>array('reporte/create','accion'=>$model->codigo,'proyecto'=>$proyecto)),
		array('label'=>'Lista de Registros', 'url'=>array('reporte/index', 'accion'=>$model->codigo,'proyecto'=>$proyecto)),
		/** Quitar comentario para usar el módulo de búsqueda **/
		array('label'=>'Buscar Registros', 'url'=>array('reporte/buscar','accion'=>$model->codigo,'proyecto'=>$proyecto)),
	);
}

?>

<h1>Ver Acción #<?php echo $model->codigo; ?></h1>

<p><i>Detalles de la acción.</i></p>

<?php if(Yii::app()->user->nivel==1): ?> <!-- Si es administrador -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo_accion',
		'accion',
		'estatus',
	),
)); ?>

<?php else: ?><!-- Si no es administrador -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo_accion',
		'accion',
	),
)); ?>

<?php endif; ?><!-- Fin de la condicion -->

<br><!-- Espacio -->

<h2>Unidad Ejecutora</h2>

<p><i>Unidades ejecutoras asociadas a la acción.</i></p>

<?php

	//Lista de unidades ejecutoras de la accion

	if(Yii::app()->user->nivel==1)
	{
		$aue=new CActiveDataProvider('AccionUe',array(
		 	'criteria'=>array(
				'condition'=>'codigo_accion=:codigo_accion AND estatus=1',
				'params'=>array(':codigo_accion'=>$model->codigo)
			)
		));
	}
	else
	{
		$aue=new CActiveDataProvider('AccionUe',array(
		 	'criteria'=>array(
				'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue AND estatus=1',
				'params'=>array(':codigo_accion'=>$model->codigo, ':codigo_ue'=>Yii::app()->user->uel)
			)
		));
	}

	$this->widget('zii.widgets.grid.CGridView',array(
		'id'=>'acciones-grid',
		'dataProvider'=>$aue,
		'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
		'columns'=>array(
			array('name'=>'Unidad Ejecutora','value'=>array('AccionUe','nombreUEL')),
			/*
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view'=>array(
						//El url para ver la unidad ejecutora
						'url'=>function($data,$row){
							$ue=UnidadEjecutora::model()->find(array('condition'=>"codigo_uel=:codigo_uel",'params'=>array(':codigo_uel'=>$data->codigo_ue)));
							return Yii::app()->createUrl('unidadEjecutora/view',array('id'=>$ue->codigo));
						},
					),					
				),
			),
			*/
		)
	));
?>
<!-- Dialogo de mensajes -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'noPresupuesto',
		'options'=>array(
			'title'=>'Advertencia',
			'autoOpen'=>false,
			'draggable'=>false,
			'resizable'=>false,
			'modal'=>true,
			'buttons'=>array(
				'Cerrar'=>'js:function(){$(this).dialog("close")}'
			)
		),
	));
?>
<!-- Mensaje -->
<p>Esta acción no posee un presupuesto.</p>

<?php
	//Termina el dialogo
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/view',array('id'=>Proyecto::model()->findByPk($proyecto)->codigo))); ?>
