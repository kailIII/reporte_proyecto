<?php
$this->breadcrumbs=array(
	'Proyectos',
);

if(Yii::app()->user->nivel==1) //Si es administrador
{
	$this->menu=array(
		array('label'=>'Crear Proyecto', 'url'=>array('create')),
		array('label'=>'Buscar Proyecto', 'url'=>array('admin')),
		array('label'=>'Proyectos por Partida', 'url'=>array('totalProyectosPorPartidaSelect')),
		array('label'=>'Proyectos y Acciones por Partida', 'url'=>array('totalProyectoAccionesPorPartida')),
		array('label'=>'Total General por Partidas y Subpartidas', 'url'=>array('generalPartidaSubpartida')),
	);
}
else
{
	$this->layout='//layouts/column1';
}

?>

<h1>Proyectos</h1>

<p><i>Seleccione un proyecto para continuar.</i></p> 


<?php if(Yii::app()->user->nivel==1): ?> <!-- Si es administrador -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'proyecto-grid',
	'dataProvider'=>$dataProvider,
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'columns'=>array(
		array('name'=>'Código', 'value'=>function($data,$row){return $data['codigo'];}),
		array('name'=>'Código SNE', 'value'=>function($data,$row){return $data['codigo_sne'];}),
		array('name'=>'Nombre del Proyecto','value'=>function($data,$row){return $data['nombre'];}),
		array('name'=>'Estatus', 'value'=>function($data, $row){return Estatus::model()->findByPk($data['estatus'])->estatus;}),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
					'view'=>array(
						//El url para ver la accion
						'url'=>function($data,$row){return Yii::app()->createUrl('proyecto/view',array('id'=>$data['codigo']));},
					),					
				),
			
		),
	),
	
));
?>

<?php else: ?><!-- Si no es administrador -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'proyecto-grid',
	'dataProvider'=>$dataProvider,
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'columns'=>array(
		array('name'=>'Código SNE', 'value'=>function($data,$row){return $data['codigo_sne'];}),
		array('name'=>'Nombre del Proyecto','value'=>function($data,$row){return $data['nombre'];}),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
					'view'=>array(
						//El url para ver la accion
						'url'=>function($data,$row){return Yii::app()->createUrl('proyecto/view',array('id'=>$data['codigo']));},
					),					
				),
			
		),
	),
	
));
?>

<?php endif; ?><!-- Fin de la condicion -->