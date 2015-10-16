<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'install-grid',
	'dataProvider' => $dataProvider,
	'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
	'columns' => array(
		'Nombre',
		'Longitud',
		'Fecha',
		array(
			'class' => 'CButtonColumn',
			'template' => '{Descargar} {Restaurar}',
			'header'=>'Opciones',
			  'buttons'=>array
			    (
			        'Descargar' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/download", array("file"=>$data["Nombre"]))',
			        ),
			        'Restaurar' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/restore", array("file"=>$data["Nombre"]))',
					),
			        'Eliminar' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/delete", array("file"=>$data["Nombre"]))',
			        ),
			    ),		
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{delete}',
			'header'=>'Eliminar',
			  'buttons'=>array
			    (
			        'delete' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/delete", array("file"=>$data["Nombre"]))',
			        ),
			    ),		
		),
	),
)); ?>