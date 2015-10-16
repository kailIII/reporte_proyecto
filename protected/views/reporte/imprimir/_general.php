<?php
	
	//widget con los registros
	$this->widget('zii.widgets.grid.CGridView',array(
		'id'=>'reportes-grid',
		'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
		'dataProvider'=>$dataProvider,
		'columns'=>array(
			array(
				'name'=>'Codigo',
				'type'=>'raw', //Tipo raw, el link se crea en la funcion
				'value'=>function($data,$proyecto){
					$aue=AccionUe::model()->findByPk($data->accion_ue);
					$accion=Acciones::model()->findByPk($aue->codigo_accion);
					//return Chtml::link($data->codigo,Yii::app()->createUrl('reporte/view',array('id'=>$data->codigo,'accion'=>$aue->codigo_accion,'proyecto'=>$accion->codigo_proyecto)));
					return $data->codigo;
				}
			),
			array(
				'name'=>'Nombre',
				'type'=>'raw', //Tipo raw para poder renderizar la propiedad overflow
				'value'=>function($data,$row){
					$aue=AccionUe::model()->findByPk($data->accion_ue);
					$val=Acciones::model()->findByPk($aue->codigo_accion)->accion;
					return "<div style='width:160px;white-space:nowrap;overflow:hidden' title='$val'>".$val."</div>";
				}, 	
			),
			'imputacion_presupuestaria',
			array(
				'name'=>'Producto o Servicio',
				'type'=>'raw',
				'value'=>function($data){
					$val= MaterialesServicios::model()->findByPk($data->material_servicio)->descripcion;
					return "<div style='width:160px;overflow:hidden;white-space:nowrap' title='$val'>".$val."</div>";
				}
			),
			array(
				'name'=>'Unidad de Medida',
				'value'=>function($data){
					$val=UnidadMedida::model()->findByPk($data->unidad_medida);
					return $val->unidad_medida;
				}
			),
			array(
				'name'=>'Presentación',
				'value'=>function($data){
					$val=Presentacion::model()->findByPk($data->presentacion);
					return $val->presentacion;
				}
			),
			'unidad_presentacion',
			'precio_unitario',
			'iva',
			'trim_i',
			'trim_ii',
			'trim_ii',
			'trim_iii',
			'trim_iv',
			'sub_total',
			'total_iva',
			'total',
		),
		'htmlOptions'=>array(
			'style'=>'overflow-x:scroll;margin-bottom:20px'
		)
	));
?>