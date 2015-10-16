<?php
$this->breadcrumbs=array(
	'Proyectos'=>array('index'),
	'Proyecto '.$model->codigo,
);

if(Yii::app()->user->nivel==1) //Si es administrador
{
	$this->menu=array(
		array('label'=>'Lista de Proyectos', 'url'=>array('index')),
		array('label'=>'Actualizar Proyecto', 'url'=>array('update', 'id'=>$model->codigo)),
		array('label'=>'Eliminar Proyecto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codigo),'confirm'=>'¿Está seguro que desea eliminar este proyecto? Los registros asociados serán eliminados')),
		array('label'=>'Buscar Proyecto', 'url'=>array('admin')),

		array('label'=>'Crear Acción', 'url'=>array('acciones/create','proyecto'=>$model->codigo)),
		//array('label'=>'Buscar Acción', 'url'=>array('acciones/admin','proyecto'=>$model->codigo)),
	);

	//Segundo menu con las acciones
	$this->menu2=array(
		array('label'=>'Registros Cargados', 'url'=>array('reporte/general','proyecto'=>$model->codigo)),
		//array('label'=>'Reporte Total de Acciones', 'url'=>array('reporteTotalAcciones', 'proyecto'=>$model->codigo)),
		array('label'=>'Ver Total por UE', 'url'=>array('reportePorUe', 'proyecto'=>$model->codigo)),
		array('label'=>'Reporte General', 'url'=>array('reporteGeneral','proyecto'=>$model->codigo)),
		array('label'=>'Trimestral por Partida', 'url'=>array('reporteTrimestral','proyecto'=>$model->codigo)),
	);
}
else
{
	//Segundo menu con las acciones
	$this->menu2=array(
		array('label'=>'Registros Cargados', 'url'=>array('reporte/general','proyecto'=>$model->codigo)),
		//array('label'=>'Reporte Total de Acciones', 'url'=>array('reporteTotalAcciones', 'proyecto'=>$model->codigo)),
		array('label'=>'Ver Total por Partidas', 'url'=>array('reporteTotalPartidas', 'proyecto'=>$model->codigo)),
	);
}


?>

<h1>Ver Proyecto #<?php echo $model->codigo; ?></h1>

<p><i>Detalles del proyecto.</i></p>

<?php if(Yii::app()->user->nivel==1): ?> <!-- Si es administrador -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'codigo_sne',
		'nombre',
		array('label'=>'Estatus', 'value'=>Estatus::model()->findByPk($model->estatus)->estatus),
	),
)); ?>

<?php else: ?><!-- Si no es administrador -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo',
		'codigo_sne',
		'nombre',
	),
)); ?>

<?php endif; ?><!-- Fin de la condicion -->

<br/>

<h2>Acciones</h2>

<p><i>Seleccione una de las acciones asociadas al proyecto para ver en detalle.</i></p>

<?php

	if(Yii::app()->user->nivel==1) //Si es administrador
	{
		//Lista de acciones del proyecto
		$dataProvider=new CActiveDataProvider('Acciones',array(
		 	'criteria'=>array(
				'condition'=>'codigo_proyecto=:codigo_proyecto',
				'params'=>array(':codigo_proyecto'=>$model->codigo)
			)
		));

		//Widget con la lista
		$this->widget('zii.widgets.grid.CGridView',array(
			'id'=>'acciones-grid',
			'dataProvider'=>$dataProvider,
			'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
			'columns'=>array(
				'codigo_accion',
				'accion',
				array('name'=>'Estatus', 'value'=>function($data, $row){return Estatus::model()->findByPk($data['estatus'])->estatus;}),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{view}',
					'buttons'=>array(
						'view'=>array(
							//El url para ver la accion
							'url'=>function($data,$row){return Yii::app()->createUrl('acciones/view',array('id'=>$data['codigo'],'proyecto'=>$data['codigo_proyecto']));},
						),					
					),
				),
			)
		));

	}
	else
	{
		//Unidad ejecutora del usuario de la sesion iniciada
		$uel=Yii::app()->user->uel;

		//Para contar el total de resultados
		$count = Yii::app()->db->createCommand("SELECT DISTINCT COUNT(*) FROM acciones a, accion_ue aue, unidad_ejecutora ue
				WHERE a.codigo = aue.codigo_accion 
				AND aue.codigo_ue = ue.codigo
				AND a.codigo_proyecto =".$model->codigo."
				AND ue.codigo = $uel
				AND aue.estatus = 1
				AND a.estatus = 1
		")->queryScalar(); //Obtener solo el primer valor de la primera fila

		//Seleccionar las acciones del usuario
		$sql = "SELECT DISTINCT a.* FROM acciones a, accion_ue aue, unidad_ejecutora ue 
				WHERE a.codigo = aue.codigo_accion 
				AND aue.codigo_ue = ue.codigo
				AND a.codigo_proyecto =".$model->codigo."
				AND ue.codigo = $uel
				AND aue.estatus = 1
				AND a.estatus = 1";

		//SQL data provider
		//Lista de acciones del usuario en el proyecto
		$dataProvider=new CSqlDataProvider($sql,array(
					'totalItemCount'=>$count,
					'keyField'=>'codigo',
					'sort'=>array(
						'attributes'=>array(
							'codigo'
						)
					),
					'pagination'=>array(
				        'pageSize'=>10,
				    ),
				));

		//Widget con la lista
		$this->widget('zii.widgets.grid.CGridView',array(
			'id'=>'acciones-grid',
			'dataProvider'=>$dataProvider,
			'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
			'columns'=>array(
				'codigo_accion',
				'accion',
				array(
					'class'=>'CButtonColumn',
					'template'=>'{view}',
					'buttons'=>array(
						'view'=>array(
							//El url para ver la accion
							'url'=>function($data,$row){return Yii::app()->createUrl('acciones/view',array('id'=>$data['codigo'],'proyecto'=>$data['codigo_proyecto']));},
						),					
					),
				),
			)
		));
	}
	
?>

<br>
<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',CController::createUrl('proyecto/index')); ?>